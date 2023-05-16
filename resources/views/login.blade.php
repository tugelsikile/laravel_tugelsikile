<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 mt-5">
                    <form class="card">
                        @csrf
                        <div class="card-header"><h3 class="card-title">LOGIN</h3> </div>
                        <div class="card-body">
                            <div class="mb-2 row">
                                <label class="col-form-label col-md-3">Username</label>
                                <div class="col-md-9">
                                    <input name="username" class="form-control">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label class="col-form-label col-md-3">Password</label>
                                <div class="col-md-9">
                                    <input name="password" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit">LOGIN</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script>
        $('.card').submit(function (e) {
            $.ajax({
                method:'post', url : '{{url('login-submit')}}',
                dataType:'json', data : $('.card').serialize(),
                error : (e) => {
                    alert(e.responseJSON.message);
                },
                success : (e) => {
                    localStorage.setItem('user', JSON.stringify(e.data));
                    alert(e.message);
                    window.location.href = window.origin;
                }
            })
            return false;
        });
    </script>

</body>
</html>
