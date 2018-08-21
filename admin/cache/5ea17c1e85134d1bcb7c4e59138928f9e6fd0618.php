<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo e(url('dashboard')); ?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                
                <!-- Catalog -->
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-book-open-variant"></i><span class="hide-menu">Catalog </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?php echo e(url('listSuppliers')); ?>" class="sidebar-link"><i class="mdi mdi-factory"></i><span class="hide-menu"> Suppliers </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('listCategories', [ 'pid' => '' ])); ?>" class="sidebar-link"><i class="mdi mdi-tag-multiple"></i><span class="hide-menu"> Categories </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-package-variant"></i><span class="hide-menu"> Products </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-view-list"></i><span class="hide-menu"> Attributes </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-radiobox-marked"></i><span class="hide-menu"> Options </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-thumb-up"></i><span class="hide-menu"> Reviews </span></a></li>
                    </ul>
                </li>
                
                <!-- Sales -->
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-shopping"></i><span class="hide-menu">Sales </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?php echo e(url('form.basic')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Orders </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Returns </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Vouchers </span></a></li>
                    </ul>
                </li>
                
                <!-- Customers -->
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Customers </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?php echo e(url('form.basic')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Customers </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Approvals </span></a></li>
                    </ul>
                </li>
                
                <!-- Campaign -->
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-bullhorn"></i><span class="hide-menu">Campaign </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?php echo e(url('form.basic')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Coupons </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Email </span></a></li>
                    </ul>
                </li>
                
                <!-- Settings -->
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Settings </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?php echo e(url('form.basic')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> System </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Words & Texts </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('listAddress')); ?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Address Book</span></a></li>
                    </ul>
                </li>
                
                <!-- Reports -->
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-chart-areaspline"></i><span class="hide-menu">Reports </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="<?php echo e(url('form.basic')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Report 1 </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo e(url('form.wizard')); ?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Report 2 </span></a></li>
                    </ul>
                </li>
                
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>