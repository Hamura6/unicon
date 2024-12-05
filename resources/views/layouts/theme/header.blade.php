<div class="main">
    <div class="topbar">

        {{-- Menu --}}
        <div class="toggle">
            <ion-icon class="fas fa-bars"></ion-icon>

        </div>


        <div class="contener">
            <div class="profile">
                <img src="{{Auth::user()->imagen}}" alt="">
            </div>
            <div class="box">
                <h3 style="color: #3b639a">{{ Auth::user()->person->nombre }} <br>{{ Auth::user()->person->apellido}}  </h3>
                <span style="color: black">{{ Auth::user()->roles->first()->name }}</span>
                <ul>
                    <li class="text-danger"><a href="{{ route('profile.edit') }} "><i
                                class="fa-sharp fa-solid fa-pen-to-square"></i> Perfil</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            <i class="fa-sharp fa-solid fa-power-off text-danger"></i> Salir
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>

            </div>

        </div>
    </div>
