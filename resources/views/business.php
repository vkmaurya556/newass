<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
</head>

<body>
    <div id='app'>
        <section class="vh-100" style="background-color: #508bfc;">
            <div class="container">
                <div class="card shadow-2-strong">
                    <div class="card-header d-flex">
                        <h4>Business</h4>
                        <div class="ms-auto">
                            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add New</button>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Business Name</th>
                                    <th>type</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row) of data">
                                    <td>
                                        <img :src="base_url +'/'+row.image" width="50">
                                    </td>
                                    <td>{{row.name}}</td>
                                    <td>{{row.type}}</td>
                                    <td>{{row.address}}</td>
                                    <td>
                                        <button class="btn btn-warning" @click="edit(row)">Edit</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>


        <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">
                    {{form.id==0?"Add New Business":"Edit Business"}}

                </h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" v-model="form.name" placeholder="name@example.com">
                    <label for="floatingInput">Business Name</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" v-model="form.type" placeholder="name@example.com">
                    <label for="floatingInput">type</label>
                </div>


                <div class="form-floating mb-3">
                    <input type="email" class="form-control" v-model="form.address" placeholder="name@example.com">
                    <label for="floatingInput">Address</label>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control" type="file" name="image" @change="updateImage">
                </div>


                <div class=" mb-3">
                    <input type="button" value="Submit" class="btn btn-success" @click="submitform">

                </div>


            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
<script>
    var myApp = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!',
            base_url: "<?= url("/"); ?>",
            form: {
                id: 0,
                name: "",
                type: "",
                address: ""
            },
            data: []
        },
        methods: {
            submitform: function() {
                let formData = new FormData();
                for (let x in this.form) {
                    formData.append(x, this.form[x]);
                }
                $.ajax({
                    url: '/api/addbusiness',
                    dataType: 'json', // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    type: 'post',
                }).then(res => {
                    console.log(res);
                    alert(res.message);
                    if (res.success) {
                        this.form = {
                            id: 0,
                            name: "",
                            type: "",
                            address: ""
                        }
                        this.getRecords();
                        this.canvas.hide();
                    }
                })

            },
            getRecords: function() {
                $.post("/api/businesslist").then(res => {
                    if (res.success) {
                        this.data = res.data;

                    }
                });
            },
            edit: function(data) {
                console.log(this.canvas);
                this.form = data;
                this.canvas.show();
            },
            updateImage: function(e) {
                console.log(e);
                this.form[e.target.name] = e.target.files[0];

            }
        },
        mounted() {
            this.getRecords();
            this.canvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
        }
    })
</script>

</html>