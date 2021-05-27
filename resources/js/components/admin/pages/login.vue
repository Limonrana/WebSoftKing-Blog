<template>
    <div class="login">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                                <div class="brand-logo">
                                    <h2 class="text-center">LRS Admin Blog</h2>
                                </div>
                                <h6 class="font-weight-light text-center">Sign in to continue.</h6>
                                <div class="pt-3">
                                    <div class="form-group">
                                        <Input type="text" size="large" v-model="data.email" placeholder="Email Address">
                                            <Icon type="ios-person-outline" slot="prepend"></Icon>
                                        </Input>
                                    </div>
                                    <div class="form-group">
                                        <Input type="password" size="large" v-model="data.password" password placeholder="Password">
                                            <Icon type="ios-lock-outline" slot="prepend"></Icon>
                                        </Input>
                                    </div>
                                    <div class="mt-3">
                                        <Button type="primary" long size="large" @click="adminLogin">Signin</Button>
                                    </div>
                                    <div class="my-2 d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <label class="form-check-label text-muted">
                                                <input type="checkbox" class="form-check-input">
                                                Keep me signed in
                                            </label>
                                        </div>
                                        <a href="#" class="auth-link text-black">Forgot password?</a>
                                    </div>
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                                            <i class="mdi mdi-facebook mr-2"></i>Connect using facebook
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>
</template>

<script>
export default {
    name: "login",
    data(){
        return {
            data : {
                email : '',
                password: ''
            },
            isLogging: false,
        }
    },
    methods: {
        async adminLogin() {
            if(this.data.email.trim()=='') return this.e('Email is required')
            if(this.data.password.trim()=='') return this.e('Password is required')
            if(this.data.password.length < 6) return this.e('Incorrect login details')
            this.isLogging = true
            const res = await this.callApi('post', '/api/admin/login', this.data)
            if(res.status===200){
                this.s(res.data.msg)
                window.location = '/dashboard'
            }else{
                if(res.status===401){
                    this.i(res.data.msg)
                }else if(res.status==422){
                    for(let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                    }
                }
                else{
                    this.swr()
                }
            }
            this.isLogging = false
        }
    }
}
</script>

<style scoped>
    .login {
        width: 100%;
    }
</style>
