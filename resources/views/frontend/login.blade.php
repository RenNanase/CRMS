<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>CRMS - Login</title>
    <style>
        body {
            background-image: url("{{ asset('frontend/dist/images/unissa.jpg') }}");
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            position: relative;
            font-family: 'Poppins', sans-serif;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1;
        }
        
        .login-container {
            position: relative;
            z-index: 2;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 450px;
            width: 90%;
            margin: 0 auto;
            margin-top: 50px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-container img {
            max-width: 150px;
            margin-bottom: 1rem;
        }
        
        .logo-container h1 {
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            line-height: 1.3;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 0.8rem;
            font-family: 'Poppins', sans-serif;
        }
        
        .btn-primary {
            border-radius: 8px;
            padding: 0.8rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }

        .system-title {
            max-width: 300px;
            margin: 0 auto;
        }
        
        #resetPasswordModal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        #resetPasswordModal .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 400px;
        }
        
        #resetPasswordModal .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        
        #resetPasswordModal .modal-header .close {
            font-size: 24px;
            cursor: pointer;
        }
        
        #resetPasswordModal .modal-body {
            padding: 20px;
        }
        
        #resetPasswordModal .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        #resetPasswordModal .modal-footer button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        #resetPasswordModal .modal-footer button.close {
            background-color: #fff;
            color: #333;
        }
        
        #resetPasswordModal .modal-footer button#sendResetLink {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="login-container">
            <div class="logo-container">
                <img src="{{ asset('frontend/dist/images/unissa_logo.png') }}" alt="UNISSA Logo" class="img-fluid">
                <div class="system-title">
                    <h1>Course Registration Management System</h1>
                </div>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" value="{{ old('email')}}" name="email" class="form-control" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                </div>
                <div class="mb-3 d-grid">
                    <button name="submit" type="submit" class="btn btn-primary">Login</button>
                    <!-- <a href="#" id="forgotPassword">Forgot Password?</a> -->
                </div>
            </form>
        </div>
    </div>
    
    <!-- <div id="resetPasswordModal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="close" onclick="document.getElementById('resetPasswordModal').style.display='none'">&times;</button>
            </div>
            <div class="modal-body">
                <p>Please enter your email address to receive a password reset link.</p>
                <input type="email" id="userEmail" placeholder="Enter your email" required>
            </div>
            <div class="modal-footer">
                <button id="sendResetLink">Send Reset Link</button>
                <button type="button" class="close" onclick="document.getElementById('resetPasswordModal').style.display='none'">Cancel</button>
            </div>
        </div>
    </div>
    
    
    <script>
document.getElementById('forgotPassword').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default link behavior
    alert("Important Notice\nTo Reset the Portal Password, please make sure your PERSONAL EMAIL account can be accessed and VALID. The TAC NO will be sent to your emails.\n\nIf there are questions and uncertainties regarding, please email to dhzrnaaa@gmail.com");
    
    // Show the email input modal
    document.getElementById('resetPasswordModal').style.display = 'block';
});

document.getElementById('sendResetLink').addEventListener('click', function() {
    const email = document.getElementById('userEmail').value; // Get the email from the input

    if (email) {
        fetch('/password/email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Get CSRF token from meta tag
            },
            body: JSON.stringify({ email: email }) // Send email in JSON format
        })
        .then(response => {
            if (response.ok) {
                alert('Password reset link sent to your email.');
                document.getElementById('resetPasswordModal').style.display = 'none'; // Close the modal
            } else {
                return response.json().then(data => {
                    alert('Error sending password reset link: ' + data.message);
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    } else {
        alert('Please enter a valid email address.');
    }
});



</script> -->


</body>
</html>
