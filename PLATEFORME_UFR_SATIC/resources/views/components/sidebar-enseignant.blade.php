<div class="sidebar-section-title">Principal</div>
<a href="{{ route('enseignant.dashboard') }}"
   class="nav-link {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid"></i> Dashboard
</a>

<div class="sidebar-section-title">Pédagogie</div>
<a href="{{ route('enseignant.cours') }}"
   class="nav-link {{ request()->routeIs('enseignant.cours') ? 'active' : '' }}">
    <i class="bi bi-book"></i> Mes cours
</a>
<a href="{{ route('enseignant.cours.create') }}"
   class="nav-link {{ request()->routeIs('enseignant.cours.create') ? 'active' : '' }}">
    <i class="bi bi-cloud-upload"></i> Déposer un cours
</a>

<div class="sidebar-section-title">Mon compte</div>
<a href="{{ route('enseignant.profil') }}"
   class="nav-link {{ request()->routeIs('enseignant.profil') ? 'active' : '' }}">
    <i class="bi bi-person-circle"></i> Mon profil
</a>