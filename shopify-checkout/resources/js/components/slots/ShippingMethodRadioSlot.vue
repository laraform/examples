<template>
  <div :class="el$.theme.classes.radioContainer">
    <label 
      :class="el$.theme.classes.radioLabel"
      :for="value"
    >
      <input
        type="radio"
        v-model="el$.model"
        :value="value"
        :class="el$.theme.classes.radio"
        :name="el$.fieldName"
        :id="value"
        @change="el$.handleChange"
      />
      <span class="info">
        <span class="left">
          <span class="carrier">{{ item.carrier }}</span> 
          <span class="delivery">{{ item.delivery_date }}</span>
        </span>
        <span class="price">{{ item.price }}</span>
      </span>
    </label>
  </div>
</template>

<script>
  export default {
    props: {
      el$: {
        type: Object,
      },
      item: {
        type: Object,
      },
      value: {
        type: [String, Number],
      },
    }
  }
</script>