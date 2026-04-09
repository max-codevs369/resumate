<style>
    :root {
        --primary-color: #4CAF50;
        --primary-hover: #45a049;
        --bg-body: #F7F7F7;
        --bg-card: #FFFFFF;
        --bg-nav: #FFFFFF;
        --text-main: #333333;
        --text-secondary: #666666;
        --border-color: #E5E5E5;
        --shadow-color: rgba(0, 0, 0, 0.05);
        --feature-icon-bg: #F1F8F4;
        --template-preview-bg: #F5F5F5;
        --green: #4CAF50;
        --green-dark: #2E7D32;
        --green-pale: #f0f7f0;
        --green-mid: #C8E6C9;
        --ink: #1c1c1c;
        --ink-mid: #555;
        --ink-faint: #999;
        --bg: #f5f4f1;
        --white: #fff;
        --rule: #e2e2de;
        --red-soft: #fff0f0;
        --red: #e53935;
    }

    [data-theme="dark"] {
        --primary-color: #4CAF50;
        --primary-hover: #66BB6A;
        --bg-body: #121212;
        --bg-card: #1E1E1E;
        --bg-nav: #1E1E1E;
        --text-main: #E0E0E0;
        --text-secondary: #A0A0A0;
        --border-color: #333333;
        --shadow-color: rgba(0, 0, 0, 0.3);
        --feature-icon-bg: #2C3E30;
        --template-preview-bg: #2A2A2A;
        --green-pale: #1a2e1d;
        --green-mid: #2d5a2f;
        --ink: #E0E0E0;
        --ink-mid: #A0A0A0;
        --ink-faint: #666;
        --bg: #121212;
        --white: #1E1E1E;
        --rule: #333333;
        --red-soft: #2a1515;
    }

    *, *::before, *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', 'Outfit', sans-serif;
        background-color: var(--bg-body);
        color: var(--text-main);
        min-height: 100vh;
        transition: background-color 0.3s ease, color 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }

    nav {
        background: var(--bg-nav);
        padding: 16px 0;
        box-shadow: 0 2px 8px var(--shadow-color);
        position: sticky;
        top: 0;
        z-index: 1000;
        border-bottom: 1px solid var(--border-color);
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 22px;
        font-weight: 700;
        color: var(--text-main);
        text-decoration: none;
        transition: opacity 0.3s ease;
    }

    .logo:hover {
        opacity: 0.8;
    }

    .logo-icon {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-menu {
        display: flex;
        list-style: none;
        gap: 32px;
        align-items: center;
    }

    .nav-menu li a {
        text-decoration: none;
        color: var(--text-secondary);
        font-weight: 500;
        font-size: 15px;
        transition: color 0.3s ease;
        position: relative;
    }

    .nav-menu li a:hover {
        color: var(--primary-color);
    }

    .nav-menu li a.active {
        color: var(--primary-color);
        font-weight: 600;
    }

    .nav-menu li a.active::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--primary-color);
    }

    .btn-register {
        background: var(--primary-color);
        color: white !important;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-register:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        padding: 12px 32px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s;
    }

    .btn-primary:hover {
        background: var(--primary-hover);
    }

    .btn-outline {
        display: inline-block;
        padding: 14px 32px;
        border: 2px solid var(--primary-color);
        border-radius: 8px;
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-outline:hover {
        background: var(--primary-color);
        color: white;
    }

    .btn-white {
        background: white;
        color: var(--primary-color);
        padding: 14px 36px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-new-cv {
        padding: 8px 16px;
        background: var(--green);
        color: #fff;
        border: none;
        border-radius: 7px;
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background .2s, transform .15s;
        text-decoration: none;
    }

    .btn-new-cv:hover {
        background: var(--green-dark);
        transform: translateY(-1px);
    }

    .theme-toggle-btn {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-main);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .theme-toggle-btn:hover {
        background-color: var(--bg-body);
        border-color: var(--primary-color);
    }

    .theme-toggle-btn i {
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .theme-toggle-btn:hover i {
        transform: rotate(20deg);
    }

    .nav-profile {
        position: relative;
    }

    .nav-avatar-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        border: 2px solid transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        outline: none;
    }

    .nav-avatar-btn:hover,
    .nav-profile.open .nav-avatar-btn {
        border-color: var(--primary-hover);
        box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.15);
    }

    .nav-avatar-btn img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-dropdown {
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        width: 240px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 12px 32px var(--shadow-color);
        overflow: hidden;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.2s ease;
        z-index: 1100;
    }

    .nav-profile.open .profile-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-header {
        padding: 16px;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-body);
    }

    .dropdown-name {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dropdown-email {
        font-size: 13px;
        color: var(--text-secondary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dropdown-menu {
        padding: 8px 0;
        list-style: none;
    }

    .dropdown-menu li a,
    .dropdown-menu li button {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 500;
        color: var(--text-secondary);
        text-decoration: none;
        background: transparent;
        border: none;
        cursor: pointer;
        font-family: inherit;
        text-align: left;
        transition: all 0.15s ease;
    }

    .dropdown-menu li a:hover,
    .dropdown-menu li button:hover {
        background: var(--bg-body);
        color: var(--primary-color);
    }

    .dropdown-menu li a i,
    .dropdown-menu li button i {
        width: 18px;
        font-size: 14px;
        color: var(--text-secondary);
        transition: color 0.15s ease;
    }

    .dropdown-menu li a:hover i,
    .dropdown-menu li button:hover i {
        color: var(--primary-color);
    }

    .dropdown-divider {
        height: 1px;
        background: var(--border-color);
        margin: 6px 0;
    }

    .dropdown-menu li.logout-item button {
        color: #e53935;
    }

    .dropdown-menu li.logout-item button i {
        color: #e53935;
    }

    .dropdown-menu li.logout-item button:hover {
        background: #fff5f5;
        color: #c62828;
    }

    [data-theme="dark"] .dropdown-menu li.logout-item button:hover {
        background: #2a1515;
    }

    .mobile-menu-toggle {
        display: none;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        padding: 8px;
        background: transparent;
        border: none;
    }

    .mobile-menu-toggle span {
        width: 25px;
        height: 3px;
        background: var(--text-main);
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .mobile-menu-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(7px, 7px);
    }

    .mobile-menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }

    .mobile-menu-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -7px);
    }

    footer {
        background: #2C2C2C;
        color: white;
        padding: 60px 0 30px;
        margin-top: auto;
    }

    [data-theme="dark"] footer {
        background: #151515;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .footer-content {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 50px;
        margin-bottom: 40px;
    }

    .footer-logo {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 16px;
        color: white;
    }

    .footer-desc {
        font-size: 14px;
        line-height: 1.7;
        color: #B0B0B0;
        margin-bottom: 20px;
    }

    .footer-column h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
        color: white;
    }

    .footer-column ul {
        list-style: none;
    }

    .footer-column ul li {
        margin-bottom: 12px;
    }

    .footer-column a {
        color: #B0B0B0;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }

    .footer-column a:hover {
        color: var(--primary-color);
    }

    .footer-bottom {
        padding-top: 30px;
        border-top: 1px solid #444;
        text-align: center;
        color: #888;
        font-size: 14px;
    }

    #backToTop {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1001;
    }

    #backToTop.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    #backToTop:hover {
        background-color: var(--primary-hover);
        transform: translateY(-5px);
    }

    .demo-content {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 40px;
        text-align: center;
    }

    .demo-content h1 {
        font-size: 48px;
        margin-bottom: 20px;
        color: var(--text-main);
    }

    .demo-content p {
        font-size: 18px;
        color: var(--text-secondary);
        margin-bottom: 40px;
    }

    @media (max-width: 968px) {
        .nav-container {
            padding: 0 24px;
        }

        .nav-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--bg-nav);
            flex-direction: column;
            padding: 20px;
            box-shadow: 0 8px 16px var(--shadow-color);
            gap: 16px;
            border-bottom: 1px solid var(--border-color);
            align-items: stretch;
        }

        .nav-menu.active {
            display: flex;
        }

        .nav-menu li {
            width: 100%;
        }

        .nav-menu li a {
            display: block;
            padding: 12px 16px;
            border-radius: 6px;
        }

        .nav-menu li a.active::after {
            display: none;
        }

        .nav-menu li a:hover {
            background: var(--bg-body);
        }

        .btn-register {
            width: 100%;
            justify-content: center;
        }

        .mobile-menu-toggle {
            display: flex;
        }

        .nav-right {
            gap: 12px;
        }

        .footer-content {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-container {
            padding: 0 20px;
        }

        .demo-content {
            padding: 0 24px;
        }

        .demo-content h1 {
            font-size: 32px;
        }

        .demo-content p {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .nav-container {
            padding: 0 16px;
        }

        .logo {
            font-size: 18px;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
        }

        .theme-toggle-btn,
        .nav-avatar-btn {
            width: 36px;
            height: 36px;
        }
    }
</style>