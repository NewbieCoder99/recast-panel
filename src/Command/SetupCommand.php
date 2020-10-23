<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class SetupCommand
 * @author Soner Sayakci <shyim@posteo.de>
 */
class SetupCommand extends Command
{
    private const OPENSSL_TOKEN_CONFIG = [
        'digest_alg' => 'aes256',
        'private_key_bits' => 4096,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ];

    /**
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function configure()
    {
        $this
            ->setName('recast:setup')
            ->setDescription('Configures a new recast instance');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @author Soner Sayakci <shyim@posteo.de>
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $host = $io->ask('MySQL Host', 'localhost');
        $hostPort = $io->ask('MySQL Port', '3306');
        $user = $io->ask('MySQL User', 'recast');
        $password = $io->ask('MySQL Password', 'iLoveReCast');
        $dbName = $io->ask('MySQL Database', 'recast');
        $appHost = $io->ask('Please specify a http url where recast will be available', 'http://app.recast.in');
        $nginxFolder = $io->ask('Please specify the nginx folder where nginx rtmp is installed', '/opt/nginx-rtmp/conf/');
        $nginxReloadCommand = $io->ask('Please specify the command that should be executed to reload nginx rtmp', 'systemctl reload nginx-rtmp');
        $registerEnabled = $io->ask('Should the registration enabled? (true / false)', 'false');

        if (parse_url($appHost, PHP_URL_SCHEME) !== 'http') {
            throw new \RuntimeException('URL must be http due nginx-rtmp limitations');
        }

        $envs = [];
        $envs['APP_HOST'] = $appHost;
        $envs['APP_ENV'] = 'prod';
        $envs['APP_SECRET'] = $this->generateRandomString();
        $envs['APP_REGISTRATION_ENABLED'] = $registerEnabled;
        $envs['MAILER_URL'] = 'null://localhost';
        $envs['JWT_PRIVATE_KEY_PATH'] = 'config/jwt/private.pem';
        $envs['JWT_PUBLIC_KEY_PATH'] = 'config/jwt/public.pem';
        $envs['JWT_PASSPHRASE'] = 'a758fddfbc878122f8b37259b8ea14c3';
        $envs['DATABASE_URL'] = sprintf('mysql://%s:%s@%s:%s/%s', $user, $password, $host, $hostPort, $dbName);
        $envs['NGINX_CONFIG_DIR'] = $nginxFolder;
        $envs['NGINX_RELOAD_COMMAND'] = $nginxReloadCommand;

        $stringEnv = [];
        foreach ($envs as $env => $value) {
            $stringEnv[] = $env . '="' . $value . '"';
        }

        file_put_contents('.env', implode("\n", $stringEnv));

        $io->success('Environment configuration generated');

        $res = openssl_pkey_new(self::OPENSSL_TOKEN_CONFIG);
        openssl_pkey_export($res, $privKey);
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey['key'];

        file_put_contents($envs['JWT_PRIVATE_KEY_PATH'], $privKey);
        file_put_contents($envs['JWT_PUBLIC_KEY_PATH'], $pubKey);

        $io->success('JWT Tokens generated');
        $io->warning('Please clear cache using command cache:clear');
    }

    /**
     * @param int $length
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     * @throws \Exception
     */
    private function generateRandomString($length = 32) : string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = \strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}