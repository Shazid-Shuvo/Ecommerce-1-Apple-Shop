<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4 class="text-center ">Sign Up</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-6 p-2 ">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-6 p-2">
                                <button onclick="onRegistration()" class="btn mt-3 w-100 mx-10 bg-gradient-primary">Complete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    async function onRegistration() {

    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (email.length === 0) {
        errorToast('Email is required')
    } else if (password.length === 0) {
        errorToast('Password is required')
    } else {
        showLoader();
        let res = await axios.post("/user-registration", {
            email: email,
            password: password
        })
        hideLoader();
        if (res.status === 200 && res.data['status'] === 'success') {
            successToast(res.data['message']);
            setTimeout(function () {
                window.location.href = '/userLogin'
            }, 2000)
        } else {
            errorToast(res.data['message'])
        }
    }
    }
</script>

