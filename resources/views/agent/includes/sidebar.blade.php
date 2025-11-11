<div class="sidebar-left">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="left-menu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('agent.dashboard') }}" class="">
                        <i class="fas fa-desktop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('agent.profile') }}" class="">
                        <i class=" fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-user-cog"></i>
                        <span>Customers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('agent.newClients') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>Add Customers
                            </a></li>

                        <li><a href="{{ route('agent.ourClients') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>List of
                                Customers</a></li>

                    </ul>
                </li>



                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fas fa-baby-carriage"></i>
                        <span>Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('agent.products') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>Products
                            </a></li>

                        <li><a href="{{ route('agent.carts') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>List of
                                Cart</a></li>

                    </ul>
                </li>




                <li>
                    <a href="{{route('agent.orders')}}" class="">
                        <i class="fas fa-box"></i>
                        <span>My Order</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fas fa-wallet"></i>
                        <span>My Wallet</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('logout') }}" class="">
                        <i class="fas fa-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
