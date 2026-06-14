<div class="sidebar-section-title">Principal</div>
<a href="{{ route('pats.dashboard') }}"
   class="nav-link {{ request()->routeIs('pats.dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid"></i> Dashboard
</a>

<div class="sidebar-section-title">Demandes</div>
<a href="{{ route('pats.demandes') }}"
   class="nav-link {{ request()->routeIs('pats.demandes') ? 'active' : '' }}">
    <i class="bi bi-inbox"></i> Toutes les demandes
    @php
        $nb = \App\Models\DemandeAdministrative::where('statut','en_attente')->count();
    @endphp
    @if($nb > 0)
        <span class="badge bg-danger ms-auto">{{ $nb }}</span>
    @endif
</a>
<a href="{{ route('pats.demandes', ['statut'=>'en_attente']) }}"
   class="nav-link {{ request('statut')==='en_attente' ? 'active' : '' }}">
    <i class="bi bi-hourglass"></i> En attente
</a>
<a href="{{ route('pats.demandes', ['statut'=>'en_cours']) }}"
   class="nav-link {{ request('statut')==='en_cours' ? 'active' : '' }}">
    <i class="bi bi-arrow-repeat"></i> En cours
</a>
<a href="{{ route('pats.demandes', ['statut'=>'validee']) }}"
   class="nav-link {{ request('statut')==='validee' ? 'active' : '' }}">
    <i class="bi bi-check-circle"></i> Validées
</a>
<a href="{{ route('pats.demandes', ['statut'=>'rejetee']) }}"
   class="nav-link {{ request('statut')==='rejetee' ? 'active' : '' }}">
    <i class="bi bi-x-circle"></i> Rejetées
</a>

<div class="sidebar-section-title">Mon compte</div>
<a href="{{ route('pats.profil') }}"
   class="nav-link {{ request()->routeIs('pats.profil') ? 'active' : '' }}">
    <i class="bi bi-person-circle"></i> Mon profil
</a>