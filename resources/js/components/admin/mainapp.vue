<template>
    <div>
        <div v-if="$store.state.user" class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex justify-content-center">
                    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                        <a class="navbar-brand brand-logo" href="index.html">Logo IMG</a>
                        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a>
                        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                            <span class="mdi mdi-sort-variant"></span>
                        </button>
                    </div>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <ul class="navbar-nav mr-lg-4 w-100">
                        <li class="nav-item nav-search d-none d-lg-block w-100">
                            <div class="input-group">
                                <div class="input-group-prepend">
                <span class="input-group-text" id="search">
                  <i class="mdi mdi-magnify"></i>
                </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Search now" aria-label="search" aria-describedby="search">
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown mr-4">
                            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" id="notificationDropdown" href="#" data-toggle="dropdown">
                                <i class="mdi mdi-bell mx-0"></i>
                                <span class="count"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
                                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                                <a class="dropdown-item">
                                    <div class="item-thumbnail">
                                        <div class="item-icon bg-success">
                                            <i class="mdi mdi-information mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <h6 class="font-weight-normal">Application Error</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            Just now
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item">
                                    <div class="item-thumbnail">
                                        <div class="item-icon bg-warning">
                                            <i class="mdi mdi-settings mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <h6 class="font-weight-normal">Settings</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            Private message
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item">
                                    <div class="item-thumbnail">
                                        <div class="item-icon bg-info">
                                            <i class="mdi mdi-account-box mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <h6 class="font-weight-normal">New user registration</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            2 days ago
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
<!--                                Image Would be here-->
                                <span class="nav-profile-name">Limon Rana</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <a class="dropdown-item">
                                    <i class="mdi mdi-settings text-primary"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="/api/logout">
                                    <i class="mdi mdi-logout text-primary"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item" v-if="this.permission[0].read">
                            <router-link to="dashboard" class="nav-link">
                                <i class="mdi mdi-home menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </router-link>
                        </li>
                        <li class="nav-item panel">
                            <a class="nav-link" data-toggle="collapse" href="#panel" aria-expanded="false" aria-controls="panel">
                                <i class="mdi mdi-server menu-icon text-white"></i>
                                <span class="menu-title text-white">Theme Panel</span>
                                <i class="menu-arrow text-white"></i>
                            </a>
                            <div class="collapse" id="panel">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a href="#" class="nav-link text-white">Header</a></li>
                                    <li class="nav-item"> <a href="#" class="nav-link text-white">Banner</a></li>
                                    <li class="nav-item"> <a href="#" class="nav-link text-white">Footer</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                                <i class="mdi mdi-circle-outline menu-icon"></i>
                                <span class="menu-title">Blogs</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">All Blogs</a></li>
                                    <li class="nav-item"> <router-link :to="{ name: 'create-blog' }" class="nav-link">Add New</router-link></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item" v-if="this.permission[1].read">
                            <router-link to="tags" class="nav-link">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Tags</span>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="this.permission[2].read">
                            <router-link to="category" class="nav-link">
                                <i class="mdi mdi-chart-pie menu-icon"></i>
                                <span class="menu-title">Category</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/tables/basic-table.html">
                                <i class="mdi mdi-blogger menu-icon"></i>
                                <span class="menu-title">Blogs</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/icons/mdi.html">
                                <i class="mdi mdi-comment-processing menu-icon"></i>
                                <span class="menu-title">Comments</span>
                            </a>
                        </li>
                        <li class="nav-item" v-if="this.permission[3].read || this.permission[4].read || this.permission[5].read">
                            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                                <i class="mdi mdi-account-key menu-icon"></i>
                                <span class="menu-title">Admin Management</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="auth">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item" v-if="this.permission[3].read"> <router-link :to="{name: 'admin-users'}" class="nav-link"> All Admin </router-link></li>
                                    <li class="nav-item" v-if="this.permission[4].read"> <router-link :to="{name: 'roles'}" class="nav-link">Role Management</router-link></li>
                                    <li class="nav-item" v-if="this.permission[5].read"> <router-link :to="{name: 'permission'}" class="nav-link">Permission Management</router-link></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="mdi mdi-account-multiple menu-icon"></i>
                                <span class="menu-title">User Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
                                <i class="mdi mdi-settings menu-icon"></i>
                                <span class="menu-title">Settings</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="settings">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a href="#" class="nav-link">SEO Tools</a></li>
                                    <li class="nav-item"> <a href="#" class="nav-link">Newslatter</a></li>
                                    <li class="nav-item"> <a href="#" class="nav-link">Cache Clear</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/api/logout">
                                <i class="mdi mdi-logout-variant menu-icon"></i>
                                <span class="menu-title">Logout</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="documentation/documentation.html">
                                <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                                <span class="menu-title">Documentation</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <router-view></router-view>

            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <router-view v-else></router-view>
        <!-- container-scroller -->
    </div>
</template>

<script>
export default {
    props: ['user', 'permission'],
    name: "mainapp",
    data() {
        return {
            isLoggedIn : false,
        }
    },
    created() {
        this.$store.commit('setUpdateUser', this.user)
        this.$store.commit('setPermission', this.permission)
    }
}
</script>

<style scoped>
    li.nav-item.panel {
        background: #4d83ff;
    }

</style>
