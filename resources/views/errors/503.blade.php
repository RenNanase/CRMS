<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRMS Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
            overflow: hidden;
        }

        .parallax {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(13, 148, 136, 0.15);
        }

        .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 5%;
        }

        .circle:nth-child(2) {
            width: 500px;
            height: 500px;
            top: 50%;
            right: -10%;
        }

        .circle:nth-child(3) {
            width: 200px;
            height: 200px;
            bottom: 20%;
            left: 10%;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .gradient-text {
            background: linear-gradient(45deg, #0d9488, #14b8a6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gear-spin {
            animation: spin 10s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="parallax">
        <div class="circle floating"></div>
        <div class="circle floating"></div>
        <div class="circle floating"></div>
    </div>

    <div class="container mx-auto px-4 h-screen flex items-center justify-center">
        <div class="text-center">
            <!-- Maintenance Icon -->
            <div class="mb-8 relative">
                <!-- Animated Gears -->
                <div class="relative w-48 h-48 mx-auto">
                    <!-- Main Gear -->
                    <svg class="gear-spin absolute inset-0" viewBox="0 0 24 24" fill="none" stroke="#0d9488"
                        stroke-width="2">
                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                        <path
                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" />
                    </svg>
                    <!-- Secondary Gear -->
                    <svg class="gear-spin absolute top-1/4 left-1/4 w-1/2 h-1/2" viewBox="0 0 24 24" fill="none"
                        stroke="#14b8a6" stroke-width="2" style="animation-direction: reverse;">
                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                        <path
                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" />
                    </svg>
                </div>
            </div>

            <!-- Main Content -->
            <div
                class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-2xl border border-teal-100 max-w-2xl mx-auto animate__animated animate__fadeIn">
                <h1 class="text-5xl font-bold gradient-text mb-4">System Maintenance</h1>
                <h2 class="text-2xl text-teal-800 mb-6">Course Registration Management System</h2>

                <div class="space-y-6">
                    <p class="text-lg text-gray-600">
                        We're currently upgrading our system to enhance your experience.
                    </p>

                    <!-- Loading Animation -->
                    <div class="flex items-center justify-center space-x-3 text-teal-600">
                        <div class="flex space-x-1">
                            <div class="w-3 h-3 bg-teal-400 rounded-full animate-bounce" style="animation-delay: -0.3s">
                            </div>
                            <div class="w-3 h-3 bg-teal-400 rounded-full animate-bounce"
                                style="animation-delay: -0.15s"></div>
                            <div class="w-3 h-3 bg-teal-400 rounded-full animate-bounce"></div>
                        </div>
                        <span class="font-medium">Please check back soon</span>
                    </div>

                    <div class="pt-6">
                        <div
                            class="inline-flex items-center px-6 py-3 bg-teal-100/50 backdrop-blur-sm text-teal-800 rounded-lg animate-pulse">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Estimated completion: 1 hour</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-gray-600 backdrop-blur-sm bg-white/30 p-4 rounded-xl inline-block">
                <p>If you need immediate assistance, please contact:</p>
                <p class="font-medium text-teal-700">dhzrnaaa@gmail.com</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const circles = document.querySelectorAll('.circle');
            circles.forEach((circle, index) => {
                circle.style.animationDelay = `${index * 0.5}s`;
            });
        });
    </script>
</body>

</html>
