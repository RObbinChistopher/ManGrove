<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vise Tech Management System</title>
    <!-- <link rel="icon" href="{{asset('/Images\ViceTech.png')}}"> -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    <style>
        .custom-quill-editor .ql-container {
            height: 150px !important;
            /* Approximate height for 6 rows */
        }

        .ql-toolbar.ql-snow {
            border: 1px solid #5d6e78 !important;
        }

        .ql-container.ql-snow {
            border: 1px solid #5d6e78 !important;
            color: white !important;
        }

        .custom-quill-editor .ql-editor {
            min-height: 150px !important;
        }

        .Sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .Sidebar::-webkit-scrollbar-thumb {
            background-color: var(--scolor);
            border-radius: 4px;
        }

        .Sidebar::-webkit-scrollbar-thumb:hover {
            background-color: var(--sBackground);
        }

        html,
        body {
            overflow: hidden;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        @media (max-width: 767px) {

            html,
            body {
                overflow: auto;
                /* Restore scrollbar for mobile screens */
            }
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 2rem;
        }

        /* .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #99519e;
            border-color: #99519e;
            color: #fff !important;
        }

        .page-link {
            color: #99519e !important;
        } */
        .vti__input {
            padding: 7px !important;
            box-shadow: none !important;
        }

        .vue-tel-input {
            box-shadow: none !important;
        }
    </style>
</head>

<body style="background: white;">
    <div id="app"></div>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.querySelector('.menu-toggle');
            const sidebar = document.querySelector('.sidebar');
            const closeBtn = document.querySelector('.close-btn');
            const overlay = document.querySelector('.overlay');
            const sidebarLinks = document.querySelectorAll('.sidebar a');

            // Open sidebar
            menuToggle.addEventListener('click', () => {
                sidebar.classList.add('open');
                overlay.classList.add('active');
            });

            // Close sidebar when clicking close button
            closeBtn.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            });

            // Close sidebar when clicking outside of it
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            });

            // Close sidebar when clicking a link
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                });
            });
        });
    </script> -->

    <!-- Bootstrap JavaScript and Popper.js -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    @stack('style')

</body>

</html>