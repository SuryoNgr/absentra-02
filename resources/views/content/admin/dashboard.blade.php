@extends('layouts.adminlayout')

@section('title', 'Absentra - Dashboard Admin')

@section('content')
<div class="content-area">
    <div class="page-content active" id="beranda">
        <div class="stats-grid">
            <div class="stat-card" onclick="showCategoryDetail('security')">
                <div class="stat-icon security">🛡️</div>
                <div class="stat-info">
                    <h3>Security</h3>
                    <div class="number">5000</div>
                    <div class="more-info">Klik untuk detail</div>
                </div>
            </div>
            <div class="stat-card" onclick="showCategoryDetail('cleaning')">
                <div class="stat-icon cleaning">🧹</div>
                <div class="stat-info">
                    <h3>Cleaning Services</h3>
                    <div class="number">1000</div>
                    <div class="more-info">Klik untuk detail</div>
                </div>
            </div>
            <div class="stat-card" onclick="showCategoryDetail('driver')">
                <div class="stat-icon driver">🚗</div>
                <div class="stat-info">
                    <h3>Driver</h3>
                    <div class="number">1500</div>
                    <div class="more-info">Klik untuk detail</div>
                </div>
            </div>
            <div class="stat-card" onclick="showCategoryDetail('pramugari')">
                <div class="stat-icon pramugari">👔</div>
                <div class="stat-info">
                    <h3>Pramugari</h3>
                    <div class="number">1000</div>
                    <div class="more-info">Klik untuk detail</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
