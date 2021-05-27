<template>
    <div class="role">
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex mb-3">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                            <p class="text-primary mb-0 hover-cursor">Role</p>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="mr-md-3 mr-xl-5">
                                    <h2>All Roles Management</h2>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end flex-wrap" v-if="isWritePermission">
                                <button type="button" @click="addModel=true" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                                    <i class="mdi mdi-plus text-muted"></i>
                                </button>
                                <button type="button" @click="addModel=true" class="btn btn-primary mt-2 mt-xl-0">Add New Role</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Roles Management</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th class="col-width">Role Type</th>
                                            <th class="col-width">isAdmin</th>
                                            <th class="col-width">Created At</th>
                                            <th class="col-width" v-if="isUpdatePermission || isDeletePermission">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="role in roles" :key="role.id">
                                            <td>{{ role.id }}</td>
                                            <td>{{ role.roleName }}</td>
                                            <td>
                                                <span class="badge badge-success" v-if="role.isAdmin == 1">Yes</span>
                                                <span class="badge badge-success" v-else-if="role.isAdmin == 0">Yes/Super</span>
                                                <span class="badge badge-info" v-else>No</span>
                                            </td>
                                            <td>{{ role.created_at }}</td>
                                            <td v-if="isUpdatePermission || isDeletePermission">
                                                <span v-if="role.isAdmin != 0">
                                                    <Button type="dark" @click="showEditModel(role)" v-if="isUpdatePermission"><i class="mdi mdi-file-check btn-icon-append"></i> Edit</Button>
                                                    <Button type="error" @click="DeleteModel(role.id)" v-if="isDeletePermission"><i class="mdi mdi-delete-sweep btn-icon-append"></i> Remove</Button>
                                                </span>
                                                <span v-else>
                                                    <Button type="dark" disabled><i class="mdi mdi-file-check btn-icon-append"></i> Edit</Button>
                                                    <Button type="error" disabled><i class="mdi mdi-delete-sweep btn-icon-append"></i> Remove</Button>
                                                </span>
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
                title="Add New Role"
                :mask-closable="false"
                :closable="false"
            >
                <div class="space">
                    <Input v-model="data.roleName" placeholder="Enter role name..."/>
                </div>
                <br>
                <div class="space">
                    <Select v-model="data.isAdmin" placeholder="Select Admin Type">
                        <Option value="1">Admin</Option>
                        <Option value="2">Editor</Option>
                        <Option value="3">Moderator</Option>
                        <Option value="4">User</Option>
                    </Select>
                </div>
                <div slot="footer">
                    <Button type="primary" @click="roleInsert">Publish</Button>
                    <Button type="default" @click="addModel=false">Close</Button>
                </div>
            </Modal>
            <!--Add Model End-->

            <!--Edit Model Start-->
            <Modal
                v-model="editModel"
                title="Edit Role"
                :mask-closable="false"
                :closable="false"
            >
                <div class="space">
                    <Input v-model="editData.roleName" placeholder="Enter role name..."/>
                </div>
                <br>
                <div class="space">
                    <Select v-model="editData.isAdmin" placeholder="Select Admin Type">
                        <Option value="1">Admin</Option>
                        <Option value="2">Editor</Option>
                        <Option value="3">Moderator</Option>
                        <Option value="4">User</Option>
                    </Select>
                </div>
                <div slot="footer">
                    <Button type="primary" @click="roleUpdate(editData.id)">Publish</Button>
                    <Button type="default" @click="editModel=false">Close</Button>
                </div>
            </Modal>
            <!--Edit Model End-->

            <!--Delete Model-->
            <Modal v-model="showDeleteModel" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
                <div style="text-align:center">
                    <p>Are you sure want to delete tag?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long :loading="modal_loading" @click="DeleteTag">Delete</Button>
                </div>
            </Modal>
            <!--End Delete Model-->

        </div>
    </div>
</template>

<script>
export default {
    name: "role",
    data() {
        return {
            data: {
                roleName: '',
                isAdmin: null
            },
            addModel: false,
            editModel: false,
            roles: [],
            editData: {
                roleName: '',
                isAdmin: null
            },
            deleteItem: {},
            showDeleteModel: false,
            modal_loading: false
        }
    },
    async created() {
        this.AllRoles()
    },
    methods: {
        //Tag Show Function
        async AllRoles() {
            const res = await this.callApi('get', '/api/roles');
            if (res.status == 200) {
                this.roles = res.data
            } else {
                this.er()
            }
        },
        //Role Insert Function
        async roleInsert() {
            if (this.data.roleName.trim() == '') return this.w('Role name is required!')
            if (!this.data.isAdmin) return this.w('Admin type is required!')
            const res = await this.callApi('post', '/api/roles',this.data);
            if (res.status == 200) {
                this.AllRoles()
                this.s('Role has been added successfully!')
                this.addModel = false
                this.data.roleName = ''
                this.data.isAdmin = ''
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
        //Role Edit Function
        async showEditModel(role) {
            let obj = {
                id: role.id,
                roleName: role.roleName,
                isAdmin: role.isAdmin
            }
            this.editData = obj
            this.editModel=true
        },
        //Role Update Function
        async roleUpdate(id) {
            if (this.editData.roleName.trim() == '') return this.w('Role name is required!')
            if (!this.editData.isAdmin) return this.w('Admin type is required!')
            const res = await this.callApi('post', '/api/roles/'+id, this.editData);
            if (res.status == 200) {
                this.AllRoles()
                this.s('Role has been successfully updated!')
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
        //Delete Tag Function
        async DeleteTag() {
            this.modal_loading = true;
            setTimeout(() => {
                const res = this.callApi('delete', '/api/tag/'+this.deleteItem);
                this.showDeleteModel = false
                this.s('Tag has been successfully deleted!')
                this.AllRoles()
            }, 2000);
        }

    }

}
</script>

<style scoped>
.role {
    width: 100%;
}
.col-width {
    width: 25%;
}
</style>
