<script>
  export default {
    mixins: [Laraform],
    created() {
      this.on('response', (response) => {
        alert(response.messages[0])
      })
    }
  }
</script>

<style scoped>
  .login-form {
    max-width: 400px;
    background: #fff;
    padding: 40px;
    margin: 50px auto;
    box-shadow: 0px 0px 24px rgba(0,0,0,0.08);
  }
</style>