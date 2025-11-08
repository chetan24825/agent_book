<!-- ========== Left Sidebar Start ========== -->
<div class="sidebar-left">

    <div data-simplebar class="h-100">

        <!--- Sidebar-menu -->
        <div id="sidebar-menu">

            <div class="card-body pt-0">
                <div class="row align-items-end">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <div class="avatar-md mb-1">
                            <img src="{{ auth()->user()->avatar ? uploaded_asset(auth()->user()->avatar) : asset('panel/images/users/avatar-1.png') }}"
                                class="img-fluid avatar-circle bg-light p-2 border-2 border-primary ml-20">
                        </div>
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
            </div>






            <ul class="left-menu list-unstyled" id="side-menu">

                <li>
                    <a href="{{ route('user.profile') }}">
                        <i class="fa fa-shapes"></i>
                        <span>Profile</span>
                    </a>

                </li>
                <li class="{{ Route::is('user.order.edit') ? 'mm-active' : '' }}">
                    <a href="{{ route('user.order') }}" class="{{ Route::is('user.order.edit') ? 'active' : '' }}">
                        <i class="fa fa-palette"></i>
                        <span> My Orders</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('user.affiliate') }}" class="">
                        <i class="fa fa-dollar-sign"></i>
                        <span>Affiliate Earners</span>
                    </a>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fa fa-gift"></i>
                        <span>Rewards</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li>
                            <a href="{{ route('user.rewards') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i> Rewards Claim
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('user.rewards.history') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i> Rewards History
                            </a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="{{ route('user.wallet') }}">
                        <i class="fas fa-wallet"></i>
                        <span> Wallet</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="#">
                        <i class="fas fa-gift"></i>
                        <span> Rewards</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fas fa-tasks"></i>
                        <span> My Task</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fas fa-truck"></i>
                        <span> Order Tracking</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fas fa-gift"></i>
                        <span> Offer a Deal</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fas fa-store"></i>
                        <span> Became a Seller</span>
                    </a>
                </li> --}}


                <li>
                    <a href="{{ route('user.royality') }}">
                        <i class="fas fa-store align-middle"></i> Royality
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.pool') }}">
                        <i class="fas fa-store align-middle"></i> Pool Income
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fa fa-tasks"></i>
                        <span>Auto Buy</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('user.level') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i> My Tier
                            </a>
                        </li>




                        <li>
                            <a href="{{ route('user.refferal') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i> Referral
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
