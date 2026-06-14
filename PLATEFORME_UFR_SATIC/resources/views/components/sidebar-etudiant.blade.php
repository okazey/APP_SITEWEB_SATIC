<div class="sidebar-section-title">Principal</div>
<a href="{{ route('etudiant.dashboard') }}"
   class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid"></i> Dashboard
</a>
<div class="sidebar-section-title">Académique</div>
<a href="{{ route('etudiant.cours') }}"
   class="nav-link {{ request()->routeIs('etudiant.cours*') ? 'active' : '' }}">
    <i class="bi bi-book"></i> Mes cours
</a>
<a href="{{ route('etudiant.emploi-du-temps') }}"
   class="nav-link {{ request()->routeIs('etudiant.emploi-du-temps') ? 'active' : '' }}">
    <i class="bi bi-calendar3"></i> Emploi du temps
</a>
<div class="sidebar-section-title">Administratif</div>
<a href="{{ route('etudiant.demandes') }}"
   class="nav-link {{ request()->routeIs('etudiant.demandes*') ? 'active' : '' }}">
    <i class="bi bi-file-earmark-text"></i> Mes demandes
</a>
<a href="{{ route('etudiant.notifications') }}"
   class="nav-link {{ request()->routeIs('etudiant.notifications') ? 'active' : '' }}">
    <i class="bi bi-bell"></i> Notifications
    @php $nb = auth()->user()->notifications()->where('lu',false)->count(); @endphp
    @if($nb > 0)
        <span class="badge bg-danger ms-auto">{{ $nb }}</span>
    @endif
</a>
<div class="sidebar-section-title">Mon compte</div>
<a href="{{ route('etudiant.profil') }}"
   class="nav-link {{ request()->routeIs('etudiant.profil') ? 'active' : '' }}">
    <i class="bi bi-person-circle"></i> Mon profil
</a>