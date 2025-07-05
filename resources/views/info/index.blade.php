@extends('dashboard.dashboard')
@section('title', 'معلومات الإدارة')

@include('dashboard.sidebar')

@section('content')
<div class="admin-info-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="page-title-info">معلومات الإدارة</h1>
                <p class="page-subtitle">إدارة وعرض معلومات التواصل الأساسية</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('info.edit', 1) }}" class="btn-primary-modern">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    تحديث المعلومات
                </a>
            </div>
        </div>
    </div>

    <!-- Info Cards Grid -->
    <div class="info-grid">
        <!-- Facebook Card -->
        <div class="info-card facebook-card">
            <div class="card-header">
                <div class="card-icon facebook-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </div>
                <h3 class="card-title">فيسبوك</h3>
            </div>
            <div class="card-content">
                <p class="card-value">{{ $info->facebook }}</p>
            </div>
        </div>

        <!-- Email Card -->
        <div class="info-card email-card">
            <div class="card-header">
                <div class="card-icon email-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <h3 class="card-title">البريد الإلكتروني</h3>
            </div>
            <div class="card-content">
                <p class="card-value">{{ $info->email }}</p>
            </div>
        </div>

        <!-- Twitter Card -->
        <div class="info-card twitter-card">
            <div class="card-header">
                <div class="card-icon twitter-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </div>
                <h3 class="card-title">تويتر</h3>
            </div>
            <div class="card-content">
                <p class="card-value">{{ $info->twitter }}</p>
            </div>
        </div>

        <!-- Phone Card -->
        <div class="info-card phone-card">
            <div class="card-header">
                <div class="card-icon phone-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                    </svg>
                </div>
                <h3 class="card-title">رقم الهاتف</h3>
            </div>
            <div class="card-content">
                <p class="card-value">{{ $info->phone }}</p>
            </div>
        </div>

        <!-- WhatsApp Card -->
        <div class="info-card whatsapp-card">
            <div class="card-header">
                <div class="card-icon whatsapp-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.085"/>
                    </svg>
                </div>
                <h3 class="card-title">الواتساب</h3>
            </div>
            <div class="card-content">
                <p class="card-value">{{ $info->whatsapp }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-info-container {
        padding: 2rem;
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title-info {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
        text-align: right;
    }

    .page-subtitle {
        color: #666;
        font-size: 1rem;
        margin: 0.5rem 0 0 0;
        text-align: right;
    }

    .btn-primary-modern {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        border: none;
        cursor: pointer;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.25rem;
        margin-top: 2rem;
    }

    .info-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s ease;
    }

    .card-icon svg {
        width: 20px;
        height: 20px;
    }

    .facebook-icon {
        background: linear-gradient(135deg, #1877f2, #42a5f5);
    }

    .email-icon {
        background: linear-gradient(135deg, #ea4335, #ff7043);
    }

    .twitter-icon {
        background: linear-gradient(135deg, #1da1f2, #42a5f5);
    }

    .phone-icon {
        background: linear-gradient(135deg, #4caf50, #66bb6a);
    }

    .whatsapp-icon {
        background: linear-gradient(135deg, #25d366, #4caf50);
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin: 0;
        text-align: right;
    }

    .card-content {
        text-align: right;
    }

    .card-value {
        font-size: 1rem;
        color: #555;
        margin: 0;
        word-break: break-all;
        padding: 0.8rem;
        background: rgba(102, 126, 234, 0.05);
        border-radius: 12px;
        border-right: 4px solid rgba(102, 126, 234, 0.3);
        direction: rtl;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .admin-info-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .page-title {
            font-size: 2rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .info-card {
            padding: 1rem;
        }
    }

    /* Animation for cards */
    .info-card {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    .info-card:nth-child(1) { animation-delay: 0.1s; }
    .info-card:nth-child(2) { animation-delay: 0.2s; }
    .info-card:nth-child(3) { animation-delay: 0.3s; }
    .info-card:nth-child(4) { animation-delay: 0.4s; }
    .info-card:nth-child(5) { animation-delay: 0.5s; }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Glassmorphism effect enhancement */
    .info-card:hover .card-icon {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* RTL Support */
    [dir="rtl"] .header-content {
        direction: rtl;
    }

    [dir="rtl"] .card-header {
        flex-direction: row-reverse;
    }
</style>

@endsection