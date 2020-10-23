<template>
  <div class="form-check" :class="{disabled: disabled}">
    <label :for="cbId" class="form-check-label">
      <input :id="cbId"
             class="form-check-input"
             type="checkbox"
             :disabled="disabled"
             v-model="model" />
      <span class="form-check-sign"></span>
    </label>
    <span>
      <slot></slot>
    </span>

  </div>
</template>
<script>
  export default{
    name: 'p-checkbox',
    model: {
      prop: 'checked'
    },
    props: {
      checked: [Array, Boolean],
      disabled: [Boolean, String],
      inline: Boolean
    },
    data () {
      return {
        cbId: ''
      }
    },
    computed: {
      model: {
        get () {
          return this.checked
        },
        set (check) {
          this.$emit('input', check)
        }
      },
      inlineClass () {
        if (this.inline) {
          return `checkbox-inline`
        }
      }
    },
    created () {
      this.cbId = Math.random().toString(16).slice(2)
    }
  }
</script>
<style>
  .form-check {
    padding: 0;
  }
  .form-check .form-check-label {
    padding-left: 25px;
  }
  .form-check .form-check-sign::before, .form-check .form-check-sign::after {
    margin-top: -17px;
  }
</style>