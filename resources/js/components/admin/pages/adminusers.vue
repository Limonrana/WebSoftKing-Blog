<template>
    <div class="adminusers">
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex mb-3">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                            <p class="text-primary mb-0 hover-cursor">Admin</p>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="mr-md-3 mr-xl-5">
                                    <h2>All Admin List</h2>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end flex-wrap" v-if="isWritePermission">
                                <button type="button" @click="addModel=true" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                                    <i class="mdi mdi-plus text-muted"></i>
                                </button>
                                <button type="button" @click="addModel=true" class="btn btn-primary mt-2 mt-xl-0">Add New</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Admin List</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th class="col-width">Admin Name</th>
                                            <th class="col-width">Admin Email</th>
                                            <th class="col-width">User Type</th>
<!--                                            <th class="col-width">Created At</th>-->
                                            <th class="col-width" v-if="isUpdatePermission || isDeletePermission">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="admin in admins" :key="admin.id">
                                            <td>{{ admin.id }}</td>
                                            <td>{{ admin.fullName }}</td>
                                            <td>{{ admin.email }}</td>
                                            <td><span class="badge badge-success">{{ admin.role.roleName }}</span></td>
<!--                                            <td>{{ admin.created_at }}</td>-->
                                            <td v-if="isUpdatePermission || isDeletePermission">
                                                <Button type="dark" @click="showEditModel(admin)" v-if="isUpdatePermission"><i class="mdi mdi-file-check btn-icon-append"></i> Edit</Button>
                                                <Button type="error" @click="DeleteModel(admin.id)" v-if="isDeletePermission"><i class="mdi mdi-delete-sweep btn-icon-append"></i> Remove</Button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Add Model Start-->
            <Modal
                v-model="addModel"
                title="Add New Admin"
                :mask-closable="false"
                :closable="false"
            >
                <div class="space">
                    <Input v-model="data.fullName" placeholder="Enter full name..."/>
                </div>
                <br>
                <div class="space">
                    <Input v-model="data.email" placeholder="Enter email address..."/>
                </div>
                <br>
                <div class="space">
                    <Input v-model="data.password" type="password" password placeholder="Enter password..."/>
                </div>
                <br>
                <div class="space">
                    <Select v-model="data.role_id" placeholder="Select Admin Type">
                        <Option :value="role.id" v-for="role in roles" :key="role.id">{{ role.roleName }}</Option>
                    </Select>
                </div>
                <div slot="footer">
                    <Button type="primary" @click="adminInsert">Publish</Button>
                    <Button type="default" @click="addModel=false">Close</Button>
                </div>
            </Modal>
            <!--Add Model End-->

            <!--Edit Model Start-->
            <Modal
                v-model="editModel"
                title="Edit Admin"
                :mask-closable="false"
                :closable="false"
            >
                <div class="space">
                    <Input v-model="editData.fullName" placeholder="Enter full name..."/>
                </div>
                <br>
                <div class="space">
                    <Input v-model="editData.email" placeholder="Enter email address..."/>
                </div>
                <br>
                <div class="space">
                    <Input v-model="editData.password" type="password" password placeholder="Enter new password (Optional)"/>
                </div>
                <br>
                <div class="space">
                    <Select v-model="editData.role_id" placeholder="Select Admin Type">
                        <Option :value="role.id" v-for="role in roles" :key="role.id">{{ role.roleName }}</Option>
                    </Select>
                </div>
                <div slot="footer">
                    <Button type="primary" @click="adminUpdate(editData.id)">Update</Button>
                    <Button type="default" @click="editModel=false">Close</Button>
                </div>
            </Modal>
            <!--Edit Model End-->

            <!--Delete Model-->
            <Modal v-model="showDeleteModel" width="360" :mask-closable="false" :closable="false">
                <p slot="header" style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
                <div style="text-align:center">
                    <p>Are you sure want to delete tag?</p>
                </div>
                <div slot="footer">
                    <Button type="default" size="large" @click="CloseDeteteModel">Close</Button>
                    <Button type="error" size="large" :loading="modal_loading" @click="DeleteTag">Delete</Button>
                </div>
            </Modal>
            <!--End Delete Model-->

        </div>
    </div>
</template>

<script>
export default {
    name: "adminusers",
    data() {
        return {
            data: {
                fullName: '',
                email: '',
                password: '',
                role_id: ''
            },
            addModel: false,
            editModel: false,
            admins: [],
            roles: [],
            editData: {
                fullName: '',
                email: '',
                password: '',
                role_id: ''
            },
            deleteItem: {},
            showDeleteModel: false,
            modal_loading: false
        }
    },
    async created() {
        this.AllAdmin()
    },
    methods: {
        //Tag Show Function
        async AllAdmin() {
            const [res, resRole] = await Promise.all([
                this.callApi('get', '/api/admin'),
                this.callApi('get', '/api/roles')
            ])
            if (res.status == 200) {
                this.admins = res.data
            } else {
                this.er()
            }
            if(resRole.status==200){
                this.roles = resRole.data
            }else{
                this.swr()
            }
        },
        //Admin-Users Insert Function
        async adminInsert() {
            if (this.data.fullName.trim() == '')return this.w('Full name is required!')
            if (this.data.email.trim() == '')return this.w('Email is required!')
            if (this.data.password.trim() == '')return this.w('Password is required!')
            if (!this.data.role_id)return this.w('User Type is required!')
            const res = await this.callApi('post', '/api/admin',this.data);
            if (res.status == 200) {
                this.AllAdmin()
                this.s('Admin has been added successfully!')
                this.addModel = false
                this.data.fullName = ''
                this.data.email = ''
                this.data.password = ''
                this.data.role_id = ''
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors){
                        this.w(res.data.errors[i][0])
                    }
                } else {
                    this.er()
                }
            }
        },
        //Admin-Users Edit Function
        async showEditModel(admin) {
            let obj = {
                id: admin.id,
                fullName: admin.fullName,
                email: admin.email,
                password: admin.password,
                role_id: admin.role_id
            }
            this.editData = obj
            this.editModel=true
        },
        //Admin-Users Update Function
        async adminUpdate(id) {
            if (this.editData.fullName.trim() == '')return this.w('Full name is required!')
            if (this.editData.email.trim() == '')return this.w('Email is required!')
            if (!this.editData.role_id)return this.w('User Type is required!')
            const res = await this.callApi('patch', '/api/admin/'+id, this.editData);
            if (res.status == 200) {
                this.AllAdmin()
                this.s('Admin has been successfully updated!')
                this.editModel = false
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors){
                        this.w(res.data.errors[i][0])
                    }
                } else {
                    this.er()
                }
            }
        },
        //Show Delete Model Function
        DeleteModel(id) {
            this.showDeleteModel = true
            this.deleteItem = id
        },
        //Delete Model Close Function
        CloseDeteteModel() {
            this.showDeleteModel = false
        },
        //Delete Tag Function
        async DeleteTag() {
            this.modal_loading = true;
            setTimeout(() => {
                const res = this.callApi('delete', '/api/admin/'+this.deleteItem);
                this.showDeleteModel = false
                this.s('Admin has been successfully deleted!')
                this.AllAdmin()
                this.modal_loading = false
            }, 2000);
        }

    }

}
</script>

<style scoped>
.adminusers {
    width: 100%;
}
.col-width {
    width: 25%;
}
</style>
