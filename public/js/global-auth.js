/* GLOBAL LOGIN */
const app = new Vue({
  el: '#loginApp',
  data: {
      form: {
          email: '',
          password: '',
      },
      errors: [],
      message: '',
      success: false,
      redirect_url:'',
  },
  methods: {
      onSubmit: function (e) {
          const {err, isValid} = customLoginValidate(this.form);
          this.errors = err

          if (isValid) {
              var formData  = new FormData($("#loginForm")[0]);
              redirect_type = $("#redirect_type").val();
              axios.post(ROOT_URL + 'sign-in', formData).then(response => {

                  if (response.data.status == 'success') {
                      this.has_error = false;
                      this.errors = []
                      setCookie('redirect_url', response.data.redirect_url, 1);
                      setCookie('access_token', response.data.access_token, 1);
                      if(redirect_type=="reload"){
                        window.location.reload();
                      }else{
                        window.location.href = response.data.redirect_url;
                      }
                  } else {
                      this.has_error = true;
                      this.message = response.data.message
                  }

              }).catch((error) => {

                  this.has_error = true;
                  this.errors.message = "API error";
              });
          }
      }
  }
});

/*GLOBAL LOGOUT */
var logout = new Vue({
        el: "#logoutDv",
        data: {
            data: 'some data'
        },
        methods: {
          logoutFn: function() {
            axios.post(ROOT_URL+'sign-out',{
            })
            .then(response => {
                if(response.data.status == "success"){
                    //deleteCookies();
                    //window.location.href = response.data.redirect_url;
                }
            })
          }
        }    
});
