<template>
    <div class="permission">
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex mb-3">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                            <p class="text-primary mb-0 hover-cursor">Permission</p>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="mr-md-3 mr-xl-5">
                                    <h2>All Permission Management</h2>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end flex-wrap">
                                <Select v-model="data.id" size="large" placeholder="Select Role Type" @on-change="changeRoleData" style="width: 250px">
                                    <Option :value="role.id" v-for="role in roles" :key="role.id">{{ role.roleName }}</Option>
                                </Select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Permission Table</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="col-width">Resource Type</th>
                                            <th>Read</th>
                                            <th>Write</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(p, i) in resources" :key="i">
                                            <td>{{ p.resourceName }}</td>
                                            <td v-if="isWritePermission || isUpdatePermission"><Checkbox v-model="p.read"></Checkbox></td>
                                            <td v-else><Checkbox v-model="p.read" disabled></Checkbox></td>

                                            <td v-if="isWritePermission || isUpdatePermission"><Checkbox v-model="p.write"></Checkbox></td>
                                            <td v-else><Checkbox v-model="p.write" disabled></Checkbox></td>

                                            <td v-if="isWritePermission || isUpdatePermission"><Checkbox v-model="p.update"></Checkbox></td>
                                            <td v-else><Checkbox v-model="p.update" disabled></Checkbox></td>

                                            <td v-if="isWritePermission || isUpdatePermission"><Checkbox v-model="p.delete"></Checkbox></td>
                                            <td v-else><Checkbox v-model="p.delete" disabled></Checkbox></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="assign_btn" v-if="isWritePermission || isUpdatePermission">
                                        <Button type="primary" @click="assignPermission" :loading="isSending" :disabled="isSending"><i class="mdi mdi-file-check btn-icon-append"></i> Assign Permission</Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                id: null
            },
            isSending: false,
            roles: [],
            resources: [
                {resourceName: 'Dashboard', read: false, write: false, update: false, delete: false, name: 'dashboard'},
                {resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags'},
                {resourceName: 'Category', read: false, write: false, update: false, delete: false, name: 'category'},
                {resourceName: 'Create Blog', read: false, write: false, update: false, delete: false, name: 'create-blog'},
                {resourceName: 'Admin-Users', read: false, write: false, update: false, delete: false, name: 'admin-users'},
                {resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'roles'},
                {resourceName: 'Permission', read: false, write: false, update: false, delete: false, name: 'permission'},
            ],
            defaultResourcesPermission: [
                {resourceName: 'Dashboard', read: false, write: false, update: false, delete: false, name: 'dashboard'},
                {resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags'},
                {resourceName: 'Category', read: false, write: false, update: false, delete: false, name: 'category'},
                {resourceName: 'Create Blog', read: false, write: false, update: false, delete: false, name: 'create-blog'},
                {resourceName: 'Admin-Users', read: false, write: false, update: false, delete: false, name: 'admin-users'},
                {resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'roles'},
                {resourceName: 'Permission', read: false, write: false, update: false, delete: false, name: 'permission'},
            ]
        }
    },
    async created() {
        this.AllRoles()
    },
    methods: {
        //Assign Permission Insert
        async assignPermission() {
            let data = JSON.stringify(this.resources);
            const res = await this.callApi('post', '/api/permission', {'permission': data, id: this.data.id});
            if (res.status == 200) {
                this.s('Permission has been assigned successfully!')
                let index = this.roles.findIndex(role => role.id == this.data.id)
                this.roles[index].permission = data
            }
            else {
                this.er()
            }

        },
        //Roles Show Function
        async AllRoles() {
            const res = await this.callApi('get', '/api/roles');
            if (res.status == 200) {
                this.roles = res.data;
                if (res.data.length) {
                    this.data.id = res.data[0].id
                    if(res.data[0].permission){
                        this.resources = JSON.parse(res.data[0].permission)
                    }
                }
            } else {
                this.er()
            }
        },
        //Change Role Function
        changeRoleData() {
            let index = this.roles.findIndex(role => role.id == this.data.id)
            let permission = this.roles[index].permission
            if (!permission) {
                this.resources = this.defaultResourcesPermission
            }
            else {
                this.resources = JSON.parse(permission)
            }
        }
    }

}
</script>

<style scoped>
.permission {
    width: 100%;
}
.col-width {
    width: 25%;
}
.assign_btn {
    margin-top: 20px;
    text-align: right;
}
</style>
