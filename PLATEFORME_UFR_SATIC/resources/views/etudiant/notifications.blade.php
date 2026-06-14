@extends('layouts.dashboard')

@section('title', 'Notifications')
@section('page-title', 'Mes Notifications')

@section('sidebar-menu')
    <x-sidebar-etudiant />
@endsection
@section('content') 
    <div class="sidebar-section-title">Principal</div>
    <a href="{{ route('etudiant.dashboard') }}" class="nav-link">
        <i class="bi bi-grid"></i> Dashboard
    </a>
    <div class="sidebar-section-title">Académique</div>
    <a href="{{ route('etudiant.cours') }}" class="nav-link">
        <i class="bi bi-book"></i> Mes cours
    </a>
    <a href="{{ route('etudiant.emploi-du-temps') }}" class="nav-link">
        <i class="bi bi-calendar3"></i> Emploi du temps
    </a>
    <div class="sidebar-section-title">Administratif</div>
    <a href="{{ route('etudiant.demandes') }}" class="nav-link">
        <i class="bi bi-file-earmark-text"></i> Mes demandes
    </a>
    <a href="{{ route('etudiant.notifications') }}" class="nav-link active">
        <i class="bi bi-bell"></i> Notifications
    </a>
    <div class="sidebar-section-title">Mon compte</div>
    <a href="{{ route('etudiant.profil') }}" class="nav-link">
        <i class="bi bi-person-circle"></i> Mon profil
    </a>

@forelse($notifications as $notif)
<div class="card-uadb p-3 mb-3 {{ $notif->lu ? '' : 'border-start border-3 border-primary' }}">
    <div class="d-flex gap-3 align-items-start">
        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:42px;height:42px;background:var(--uadb-bleu-light);">
            <i class="bi bi-{{ match($notif->type) {
                'succes'  => 'check-circle-fill text-success',
                'alerte'  => 'exclamation-circle-fill text-warning',
                'erreur'  => 'x-circle-fill text-danger',
                default   => 'info-circle-fill text-primary',
            } }}"></i>
        </div>
        <div class="flex-grow-1">
            <p style="margin:0;font-size:0.88rem;color:#333;">{{ $notif->message }}</p>
            <small style="color:var(--uadb-texte);">
                {{ $notif->date_envoi?->diffForHumans() }}
            </small>
        </div>
        @if(!$notif->lu)
        <form method="POST"
              action="{{ route('etudiant.notifications.lire', $notif->id) }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check"></i> Lu
            </button>
        </form>
        @else
        <span class="badge bg-secondary">Lu</span>
        @endif
    </div>
</div>
@empty
<div class="card-uadb p-5 text-center">
    <i class="bi bi-bell-slash" style="font-size:4rem;color:#ccc;"></i>
    <h5 class="mt-3 text-muted">Aucune notification.</h5>
</div>
@endforelse

<div class="d-flex justify-content-center mt-4">
    {{ $notifications->links('pagination::bootstrap-5') }}
</div>

@endsection