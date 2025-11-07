<div class="sidebar-left">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="left-menu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="">
                        <i class="fas fa-desktop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>




                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-th-list"></i>
                        <span>Agents </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li><a href="{{ route('admin.agents') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>List of Agents
                            </a></li>

                        <li><a href="{{ route('admin.agents.new') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>Add New Agents
                            </a></li>
                    </ul>
                </li>






                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-chart-area"></i>
                        <span>Categories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.categories') }}"><i class="fas fa-chart-area align-middle"></i>
                                List Of Categories</a></li>

                    </ul>
                </li>





                <li class="{{ Route::is('admin.product.edit') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow {{ Route::is('admin.product.edit') ? 'mm-active' : '' }} ">
                        <i class="fas fa-baby-carriage"></i>
                        <span>Product </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{ Route::is('admin.product.edit') ? 'mm-active' : '' }}"><a
                                class="{{ Route::is('admin.product.edit') ? 'active' : '' }}"
                                href="{{ route('admin.products') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>List Of Products </a>
                        </li>
                        <li><a href="{{ route('admin.add-product') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>Add New
                                Products</a>
                        </li>


                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-window-restore"></i>
                        <span>Orders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>Lists Of
                                Orders</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url('admin/uploaded-files') }}" class="">
                        <i class="far fa-image"></i>
                        <span>Uploads</span>
                    </a>
                </li>





                <li
                    class="{{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow {{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'mm-active' : '' }}">
                        <i class="fa fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.settings') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i> General
                            </a></li>
                        <li
                            class="{{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.custom-page-all') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle {{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'active' : '' }} "></i>
                                Custom Pages
                            </a>
                        </li>


                    </ul>
                </li>


                <li>
                    <a href="{{ route('logout') }}" class="">
                        <i class="fas fa-desktop"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
