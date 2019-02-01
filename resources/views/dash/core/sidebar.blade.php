    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="info-container">
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="@if($active == route('xml.items'))active @else @endif">
                        <a href="{{ route('xml.items') }}">
                            <i class="material-icons">unarchive</i>
                            <span>XML Items</span>
                        </a>
                    </li>
                    <li class="@if($active == route('xml.items.custom'))active @else @endif">
                        <a href="{{ route('xml.items.custom') }}">
                            <i class="material-icons">unarchive</i>
                            <span>XML Custom Items</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2019 <a href="javascript:void(0);">Jblue XMLToDatabase</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0 - L2jBlueHeart Project <br>
                    <b>Devloper: </b> TurtleLess
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>