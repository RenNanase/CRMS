<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Minor Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .field {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
        }

        .hop-section {
            margin-top: 40px;
            border: 1px solid #000;
            padding: 15px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>MINOR REGISTRATION FORM</h2>
        <p>Date: {{ $date }}</p>
    </div>

    <div class="section">
        <div class="section-title">Student Information</div>
        <div class="field">
            <span class="label">Name:</span> {{ $student->name }}
        </div>
        <div class="field">
            <span class="label">Matric Number:</span> {{ $student->matric_number }}
        </div>
        <div class="field">
            <span class="label">Current Semester:</span> {{ $student->current_semester }}
        </div>
        <div class="field">
            <span class="label">Programme:</span> {{ $student->programme }}
        </div>
        <div class="field">
            <span class="label">Phone:</span> {{ $student->phone }}
        </div>
        <div class="field">
            <span class="label">Email:</span> {{ $student->email }}
        </div>
    </div>

    <div class="section">
        <div class="section-title">Academic Records</div>
        <div class="field">
            <span class="label">Semester 1 GPA:</span> {{ $semester1_gpa ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Semester 2 GPA:</span> {{ $semester2_gpa ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Semester 3 GPA:</span> {{ $semester3_gpa ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Semester 4 GPA:</span> {{ $semester4_gpa ?? 'N/A' }}
        </div>
        <div class="field">
            <span class="label">Current CGPA:</span> {{ $cgpa }}
        </div>
    </div>

    <div class="section">
        <div class="section-title">Minor Course Details</div>
        <div class="field">
            <span class="label">Course Code:</span> {{ $course->course_code }}
        </div>
        <div class="field">
            <span class="label">Course Name:</span> {{ $course->course_name }}
        </div>
        <div class="field">
            <span class="label">Faculty:</span> {{ $course->faculty }}
        </div>
        <div class="field">
            <span class="label">Proposed Start Semester:</span> {{ $proposed_semester }}
        </div>
    </div>

    <div class="hop-section">
        <div class="section-title">Head of Programme Approval</div>
        <div class="field">
            <p><span class="label">Comments:</span> _________________________________________________</p>
        </div>
        <div class="field">
            <p><span class="label">Name:</span> _________________________________________________</p>
        </div>
        <div class="field">
            <p><span class="label">Signature:</span> _____________________________________________</p>
        </div>
        <div class="field">
            <p><span class="label">Date:</span> _________________________________________________</p>
        </div>
    </div>
</body>

</html>
