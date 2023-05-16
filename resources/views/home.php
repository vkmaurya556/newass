<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <style>
        .star {
            font-size: 40px;
            display: inline-block;
            color: gray;
        }

        .star:last-child {
            margin-right: 0;
        }

        .star:before {
            content: '\2605';
        }

        .star.on {
            color: orange;
        }

        .star.half:after {
            content: '\2605';
            color: orange;
            position: absolute;
            margin-left: -33.5px;
            width: 17px;
            overflow: hidden;
        }


        /* component */

        .star-rating {
            /* border: solid 1px #ccc; */
            display: flex;
            flex-direction: row-reverse;
            font-size: 3em;
            justify-content: space-around;
            padding: 0 .2em;
            text-align: center;
            width: 5em;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ccc;
            cursor: pointer;
        }

        .star-rating :checked~label {
            color: #f90;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #fc0;
        }

        .star1 {
            font-size: 30px;
        }
    </style>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Business Listing</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item" v-if="login_username==null">
                            <a class="nav-link active" aria-current="page" href="#" onclick='$("#loginmodal").modal("show");'>Login</a>
                        </li>

                        <li class="nav-item dropdown" v-if="login_username!=null">
                            <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{login_username}}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#" @click="logout">Logout</a></li>

                            </ul>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>


        <section class="vh-100" style="background-color: #508bfc;overflow:auto">
            <div class="container">

                <div class="card my-3" v-for="(row) of data">

                    <div class="row align-items-center">
                        <div class="col-sm-2">
                            <img :src="base_url +'/'+row.image" width="150">
                        </div>
                        <div class="col-sm-8">
                            <h1>
                                {{row.name}}
                            </h1>
                            <div class="badge bg-danger">{{row.type}}</div>
                            {{row.rating}}
                            <div class="stars">
                                <span class="star on" v-for="item in row.rating"></span>
                                <!-- <span class="star half"></span> -->
                                <span class="star" v-for="item in (5-row.rating)"></span>


                            </div>



                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-info fw-bold" @click="show_comment(row)">Rate Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal" id="ratingmodal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Rating
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="star-rating align-items-center w-100">
                            <input type="radio" id="5-stars" v-model="rating_frm.rating" value="5" />
                            <label for="5-stars" class="star1">&#9733;</label>
                            <input type="radio" id="4-stars" v-model="rating_frm.rating" value="4" />
                            <label for="4-stars" class="star1">&#9733;</label>
                            <input type="radio" id="3-stars" v-model="rating_frm.rating" value="3" />
                            <label for="3-stars" class="star1">&#9733;</label>
                            <input type="radio" id="2-stars" v-model="rating_frm.rating" value="2" />
                            <label for="2-stars" class="star1">&#9733;</label>
                            <input type="radio" id="1-star" v-model="rating_frm.rating" value="1" />
                            <label for="1-star" class="star1">&#9733;</label>

                        </div>

                        <div>
                            <textarea v-model="rating_frm.comment" class="form-control" cols="30" rows="10" placeholder="Comment"></textarea>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-lg btn-block w-100 mt-3" type="submit" @click="comment">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="loginmodal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="form_type==1">
                            Login
                        </h5>
                        <h5 class="modal-title" v-if="form_type==2">
                            Sign Up
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="form_type==1">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" v-model="login_frm.username" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" v-model="login_frm.password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>

                            <div class="text-center text-danger">
                                {{login_error}}
                            </div>


                            <button class="btn btn-primary btn-lg btn-block w-100 mt-5" type="submit" @click="login">Login</button>


                            <hr class="my-4" />
                            <div class="d-flex">
                                <button class="btn btn-lg btn-block btn-danger rounded-0 w-100" type="submit">Forget Password</button>
                                <button class="btn btn-lg btn-block btn-warning rounded-0 w-100" type="button" @click="form_type=2">New User</button>
                            </div>
                        </div>
                        <div v-if="form_type==2">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" v-model="signup_frm.name" placeholder="name@example.com">
                                <label for="floatingInput">Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" v-model="signup_frm.username" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" v-model="signup_frm.password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" v-model="signup_frm.repassword" placeholder="Password">
                                <label for="floatingPassword">Re-Type Password</label>
                            </div>

                            <div class="text-center text-danger">
                                {{signup_error}}
                            </div>


                            <button class="btn btn-primary btn-lg btn-block w-100 mt-3" type="submit" @click="signup">Sign Up</button>


                            <hr class="my-4" />
                            <div class="d-flex">

                                <button class="btn btn-lg btn-block btn-warning rounded-0 w-100" style="" type="button" @click="form_type=1">Existing Login</button>
                            </div>

                        </div>



                    </div>

                </div>
            </div>
        </div>


    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</html>
<script>
    var myApp = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!',
            base_url: "<?= url("/"); ?>",
            data: [],
            login_frm: {
                username: "",
                password: "",
                type: 2
            },
            signup_frm: {
                name: "",
                username: "",
                password: "",
                repassword: "",
                type: 2
            },
            login_error: "",
            signup_error: "",
            form_type: 1,
            login_username: localStorage.getItem("login_username"),
            login_token: localStorage.getItem("login_token"),
            rating_frm: {
                rating: 0,
                comment: ""
            }
        },
        methods: {

            getRecords: function() {
                $.post(this.base_url + "/api/businesslist").then(res => {
                    if (res.success) {
                        res.data.forEach(function(v, i) {
                            res.data[i].rating = (parseFloat(v.total_rating) / parseInt(v.total_rated_users)).toFixed(2);
                            if (res.data[i].rating == NaN) {
                                res.data[i].rating = 0;
                            }
                        })
                        this.data = res.data;
                    }
                });
            },
            login: function() {
                $.post(this.base_url + "/api/userlogin", this.login_frm).then(res => {
                    console.log(res);
                    if (res.success == true) {
                        this.login_username = res.name;
                        this.login_token = res.token;
                        localStorage.setItem("login_username", res.name);
                        localStorage.setItem("login_token", res.token);
                        $("#loginmodal").modal("hide");

                    } else {
                        console.log(res.message);
                        this.login_error = res.message;
                    }
                });

            },
            signup: function() {
                if (this.signup_frm.password != this.signup_frm.repassword) {
                    this.signup_error = "Password Not Matched";
                    return;
                }
                $.post(this.base_url + "/api/usersignup", this.signup_frm).then(res => {
                    console.log(res);
                    if (res.success == true) {
                        this.login_username = res.name;
                        this.login_token = res.token;
                        localStorage.setItem("login_username", res.name);
                        localStorage.setItem("login_token", res.token);
                        alert(res.message);
                        this.signup_frm = {
                            name: "",
                            username: "",
                            password: "",
                            repassword: "",
                            type: 2
                        };
                        this.form_type = 1;
                        this.login_error = '';
                        $("#loginmodal").modal("hide");

                    } else {
                        console.log(res.message);
                        this.login_error = res.message;
                    }
                });

            },
            comment: function() {
                $.post(this.base_url + "/api/userrating", {
                    ...this.rating_frm,
                    login_token: this.login_token
                }).then(res => {

                    alert(res.message)
                    if (res.success) {
                        $("#ratingmodal").modal("hide");
                    }
                });
            },
            show_comment: function(data) {
                if (this.login_token == null || this.login_token == undefined) {
                    alert("Please Login First");
                    return;
                }
                $("#ratingmodal").modal("show");

                this.rating_frm.business_id = data.id;
            },
            logout: function() {
                localStorage.removeItem("login_username");
                localStorage.removeItem("login_token");
                this.login_username = null;
                this.login_token = null;
            }
        },
        mounted() {
            this.getRecords();
        }
    })
</script>