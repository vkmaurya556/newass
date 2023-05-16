<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>

    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Sign in</h3>
                            <form action="{{url('login')}}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="1">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" name="username" placeholder="name@example.com">
                                    <label for="floatingInput">Email address</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                </div>


                                <button class="btn btn-primary btn-lg btn-block w-100 mt-5" type="submit">Login</button>

                                <!-- <hr class="my-4">

                                <div class="d-flex">

                                    <button class="btn btn-lg btn-block btn-danger rounded-0 w-100" style="" type="submit"><i class="fab fa-google me-2"></i> Forget Password</button>
                                    <button class="btn btn-lg btn-block btn-warning rounded-0 w-100" style="" type="submit"><i class="fab fa-facebook-f me-2"></i>New User</button>

                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>