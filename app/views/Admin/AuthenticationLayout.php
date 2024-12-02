<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login AdminLTE</title>
    <link rel="stylesheet" href="/path/to/your/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <div class="auth-container">
        <?php echo $this->contentForLogin; ?>
    </div>


    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    },
                    backgroundColor: {
                        "overlay-10": "rgba(0,0,0,0.1)",
                        "overlay-20": "rgba(0,0,0,0.2)",
                        "overlay-30": "rgba(0,0,0,0.3)",
                        "overlay-50": "rgba(0,0,0,0.5)",
                        "overlay-70": "rgba(0,0,0,0.7)",
                    },
                    fontSize: {
                        xxs: ".5rem",
                    },
                    screens: {
                        mobile: "640px", // Kích thước mobile
                        tablet: "768px", // Kích thước tablet
                        laptop: "1366px", // Kích thước laptop
                        desktop: "1920px", // Kích thước màn hình 23.8 inch
                    },
                }
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <?php if (isset($_SESSION['toastMessage'])): ?>
        <script>
            window.onload = function() {
                var toastMessage = "<?php echo $_SESSION['toastMessage']; ?>";
                var toastSuccess = "<?php echo $_SESSION['toastSuccess'] ? 'true' : 'false'; ?>";

                // Cấu hình mặc định cho Toastr
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                // Gọi toastr để hiển thị thông báo
                if (toastSuccess === 'true') {
                    toastr.success(toastMessage);
                } else {
                    toastr.error(toastMessage);
                }
            };
        </script>
        <?php
        unset($_SESSION['toastMessage']);
        unset($_SESSION['toastSuccess']);
        ?>
    <?php endif; ?>
</body>

</html>