<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Georgia, "Times New Roman", serif;
        background:
            linear-gradient(180deg, rgba(249, 245, 239, 0.96), rgba(228, 236, 240, 0.96)),
            repeating-linear-gradient(90deg, rgba(58, 79, 99, 0.05) 0, rgba(58, 79, 99, 0.05) 1px, transparent 1px, transparent 48px);
        color: #243640;
    }

    .page-shell {
        max-width: 1100px;
        margin: 28px auto;
        padding: 24px;
    }

    .hero {
        background: linear-gradient(135deg, #fff9f1 0%, #e5eff2 48%, #d1dee5 100%);
        border: 8px solid #f1e5da;
        border-radius: 24px;
        box-shadow: 0 24px 60px rgba(45, 63, 77, 0.2);
        overflow: hidden;
        position: relative;
    }

    .hero::after {
        display: none;
    }

    .hero-inner {
        padding: 38px 40px 58px;
        position: relative;
        z-index: 1;
    }

    h1 {
        margin: 0;
        text-align: center;
        font-size: 54px;
        letter-spacing: 2px;
    }

    .subtitle {
        text-align: center;
        margin: 10px 0 26px;
        font-size: 18px;
        color: #5d6f75;
    }

    .nav-links {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 14px;
        margin-bottom: 30px;
    }

    .nav-links a {
        text-decoration: none;
        color: #355567;
        font-weight: bold;
        padding: 8px 12px;
        border-bottom: 2px solid transparent;
        transition: color 0.2s ease, border-color 0.2s ease;
    }

    .nav-links a:hover,
    .nav-links a.active {
        color: #b56e42;
        border-bottom-color: #b56e42;
    }

    .panel {
        max-width: 820px;
        margin: 0 auto;
        background: rgba(255, 252, 248, 0.92);
        border: 1px solid #d8ddd7;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 12px 28px rgba(54, 70, 82, 0.08);
    }

    .panel h2 {
        margin-top: 0;
        margin-bottom: 18px;
        font-size: 28px;
        color: #2e4958;
    }

    .panel p,
    .panel li {
        line-height: 1.6;
    }

    .row {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 10px;
        align-items: start;
        margin-bottom: 12px;
    }

    label {
        font-weight: bold;
    }

    .required {
        color: #c62828;
    }

    input[type="text"],
    input[type="email"],
    textarea,
    select {
        width: 100%;
        padding: 9px 10px;
        border: 1px solid #b2c0c7;
        border-radius: 6px;
        font-size: 14px;
        background: #fffdfa;
        color: #243640;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: #b56e42;
        box-shadow: 0 0 0 3px rgba(181, 110, 66, 0.14);
    }

    textarea {
        min-height: 110px;
        resize: vertical;
    }

    .radio-group {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        padding-top: 4px;
    }

    .radio-group label {
        font-weight: normal;
    }

    .error {
        grid-column: 2;
        color: #c62828;
        font-size: 13px;
        margin-top: -4px;
    }

    .success {
        max-width: 820px;
        margin: 0 auto 20px;
        padding: 14px 16px;
        border: 1px solid #a8c8b1;
        background: #edf7ef;
        color: #27553a;
        border-radius: 10px;
        font-weight: bold;
    }

    .error-box {
        background: #fdecea;
        border-color: #e0a7a2;
        color: #8a2a23;
    }

    .wide-panel {
        max-width: 100%;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 18px;
        background: #fffdfa;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #d6dee2;
        padding: 10px 12px;
        text-align: left;
    }

    .data-table th {
        background: #e9f0ec;
        color: #355567;
    }

    .message-box {
        background: #fbfcfb;
        border-left: 5px solid #b56e42;
        padding: 18px 18px 18px 20px;
        line-height: 1.6;
        color: #355061;
    }

    .actions {
        margin-top: 16px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    input[type="submit"] {
        border: none;
        background: #b56e42;
        color: #fff;
        padding: 11px 24px;
        font-size: 15px;
        border-radius: 6px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background: #995630;
    }

    .button-link {
        display: inline-block;
        text-decoration: none;
        border: none;
        background: #b56e42;
        color: #fff;
        padding: 11px 24px;
        font-size: 15px;
        border-radius: 6px;
        cursor: pointer;
    }

    .button-link:hover {
        background: #995630;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-top: 18px;
    }

    .info-card {
        background: rgba(255, 252, 248, 0.96);
        border: 1px solid #d8ddd7;
        border-radius: 14px;
        padding: 18px;
        margin-top: 16px;
    }

    .hero-photo {
        width: 100%;
        max-width: 760px;
        display: block;
        margin: 0 auto 22px;
        border-radius: 18px;
        border: 1px solid #d8ddd7;
        background: #fff;
    }

    @media (max-width: 900px) {
        .row {
            grid-template-columns: 1fr;
        }

        .error {
            grid-column: 1;
        }
    }
</style>
