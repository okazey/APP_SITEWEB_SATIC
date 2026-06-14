@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Tableau de bord')

@section('sidebar-menu')
    <div class="sidebar-section-title">Principal</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
        <i class="bi bi-grid"></i> Dashboard
    </a>
    <div class="sidebar-section-title">Gestion</div>
    <a href="#" class="nav-link">
        <i class="bi bi-people"></i> Utilisateurs
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-newspaper"></i> Actualités
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-file-earmark"></i> Documents
    </a>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-12">
        <h4 style="color:var(--uadb-bleu);font-weight:700;">
            Bienvenue, {{ auth()->user()->prenom }} 👋
        </h4>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-primary bg-opacity-10 mb-3">
                <i class="bi bi-people-fill text-primary"></i>
            </div>
            <div class="stat-number">0</div>
            <div class="stat-label">Utilisateurs</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-success bg-opacity-10 mb-3">
                <i class="bi bi-book-fill text-success"></i>
            </div>
            <div class="stat-number">0</div>
            <div class="stat-label">Cours publiés</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-warning bg-opacity-10 mb-3">
                <i class="bi bi-file-earmark-text text-warning"></i>
            </div>
            <div class="stat-number">0</div>
            <div class="stat-label">Demandes en attente</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat">
            <div class="stat-icon bg-info bg-opacity-10 mb-3">
                <i class="bi bi-newspaper text-info"></i>
            </div>
            <div class="stat-number">0</div>
            <div class="stat-label">Actualités</div>
        </div>
    </div>
</div>
@endsection