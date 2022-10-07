<template>
    <div>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">ព័ត៌មានអតិថិជន</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/home">ទំព័រដើម</a></li>
                                <li class="breadcrumb-item active">ព័ត៌មានអតិថិជន</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <button type="button"
                                                @click="newCustomer"
                                                class="btn btn-outline-primary btn-sm">
                                            ព័ត៌មានអតិថិជនថ្មី
                                        </button>
                                    </div>

                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-outline-primary">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>លេខ</th>
                                            <th>ឈ្មោះអតិថិជន</th>
                                            <th>ភេទ</th>
                                            <th>លេខទូរស័ព្ទ</th>
                                            <th>អាសយដ្ឋាន</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="cus in customers.data" :key="customers.id">
                                            <td>{{ cus.id }}</td>
                                            <td>{{ cus.name }}</td>
                                            <td v-show="cus.gender==1">ប្រុស</td>
                                            <td v-show="cus.gender==0">ស្រី</td>
                                            <td>{{ cus.phone }}</td>
                                            <td>{{ cus.address }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" @click="infoCustomer(cus)" class="btn btn-outline-primary btn-sm">កែប្រែ</button>
                                                    <button type="button" @click="deleteCustomer(cus.id)" class="btn btn-outline-danger btn-sm">លុប</button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <pagination :data="customers" @pagination-change-page="getCustomer" :limit="2" align="right" size="small"></pagination>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>

        <div class="modal fade" id="modal-customer">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="method ? editCustomer() : createCustomer()" role="form" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">ព័ត៌មានអតិថិជន</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">ឈ្មោះអតិថិជន</label>
                                    <input type="text" class="form-control"
                                           v-model="form.name"
                                           name="name" id="name"
                                           placeholder="ឈ្មោះអតិថិជន" autocomplete="name" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">ភេទ</label>
                                    <select class="form-control"
                                            v-model="form.gender"
                                            name="gender" id="gender">
                                        <option value="1">ប្រុស</option>
                                        <option value="0">ស្រី</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="phone">លេខទូរស័ព្ទ</label>
                                    <input type="text" class="form-control"
                                           v-model="form.phone"
                                           name="phone" id="phone"
                                           placeholder="លេខទូរស័ព្ទ" autocomplete="phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">អាស័យដ្ឋាន</label>
                                    <input type="text" class="form-control"
                                           v-model="form.address"
                                           name="address" id="address"
                                           placeholder="អាស័យដ្ឋាន" autocomplete="address" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">បោះបង់</button>
                            <button type="submit" class="btn btn-primary">រក្សាទុក</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

</template>

<script>
    export default {
        props:['token'],
        data(){
            return {
                method:false,
                customers:{},
                form: new Form({
                    id:"",
                    name:"",
                    gender:"1",
                    phone:"",
                    address:"",
                    _token:this.token.value
                })
            }
        },
        mounted() {
            this.getCustomer();
            //Save Data not need refresh page
            Fire.$on('onCreated',(page = 1) => {
                this.getCustomer(page);
            });
        },
        methods:{
            newCustomer(){
                this.method = false;
                this.form.reset();
                $('#modal-customer').modal('show');
            },
            infoCustomer(cus){
                this.method = true;
                this.form.reset();
                this.form.fill(cus);
                this.form._token = this.token.value;
                $('#modal-customer').modal('show');
            },
            createCustomer(){
                this.form.post('customer')
                    .then(res => {
                        Fire.$emit('onCreated',1);
                        $('#modal-customer').modal('hide');
                        //console.log(res.data);
                    })
                    .catch(error => console.log(error));
            },
            editCustomer(){
                this.form.put('customer/' + this.form.id)
                    .then(res => {
                        Fire.$emit('onCreated',this.customer.current_page);
                        //console.log(res);
                        $('#modal-customer').modal('hide');
                    }).catch(err => console.log(err));
            },
            getCustomer(page = 1) {
                axios.get('customer/rows?page=' + page)
                    .then(res => {
                        this.customers = res.data;
                        console.log(res.data)
                    })
                    .catch(err => console.log(err));
            },
            deleteCustomer(id){
                /*if(confirm('Are you sure?')){
                    this.form.delete('customer/' + id)
                        .then(() => {
                            Fire.$emit('onCreated',this.customer.current_page);
                        }).catch(err => console.log(err));
                }*/
                Vue.swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('customer/' + id)
                            .then(() => {
                                Vue.swal(
                                    'Deleted!',
                                    'Your customer has been deleted.',
                                    'success'
                                );
                                Fire.$emit('onCreated',this.customer.current_page);
                            }).catch(err => console.log(err));

                    }
                })
            }
        }
    }
</script>

<style scoped>
    .pagination.pagination-sm{
        margin-bottom: 0px !important;
    }
</style>
