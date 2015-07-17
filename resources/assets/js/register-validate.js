$("#form-register").validate({
	rules:{
		username:{
			required:true,
			minlength:3,
			remote:{
				url:"check/check-username",
				type:"post"
			}
		},
		password:{
			required:true,
			minlength:6
		},
		password_confirmation: {
			equalTo:"#password"
		},
		email: {
			required:true,
			email: true,
			remote:{
				url:"check/check-email",
				type:"post"
			}
		}
	},
	messages: {
		username:{
			remote:"This username is already exists"
		},
		email: {
			remote: "This email is already exists"
		}
	}
})