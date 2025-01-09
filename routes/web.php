<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Log;
use App\Models\Course; // Added import statement for the Course model
use Illuminate\Support\Facades\DB; // Added import statement for DB facade
use App\Http\Controllers\CourseRequestController; // Added import statement for CourseRequestController
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AdminTimetableController;
use App\Models\Student; // Added import statement for the Student model
use App\Http\Controllers\MinorRegistrationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProgramStructureController;
use App\Models\Faculty;
use App\Http\Controllers\DeanController;
use App\Http\Controllers\RegistrationPeriodController;
use App\Http\Controllers\AcademicPeriodController;
use App\Http\Controllers\CourseOfferingController;
use Illuminate\Http\Request;


// Add this debug route to check auth status
Route::get('/check-auth', function () {
    dd([
        'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'session' => session()->all()
    ]);
});


// Public routes (accessible without login)
Route::get('/', [SessionController::class, 'index'])->name('login');
Route::post('/', [SessionController::class, 'login']);
Route::get('/logout', [SessionController::class, 'logout'])->name('logout');


// Major course registration
Route::middleware(['auth', 'check.registration:major'])->group(function () {
    Route::post('/course-request', [CourseRequestController::class, 'store']);
});

// Minor course registration
Route::middleware(['auth', 'check.registration:minor'])->group(function () {
    Route::get('/minor-registration/create', [MinorRegistrationController::class, 'create']);
    Route::post('/minor-registration', [MinorRegistrationController::class, 'store']);
});

    //Export routes
    Route::get('/timetables/export', [StudentController::class, 'exportTimetable'])->name('timetables.export');


    //api
    Route::get('/faculties/{faculty}/programs', function (Faculty $faculty) {
        return $faculty->programs;
    });
    Route::get('/api/faculties/{faculty}/programs', function (App\Models\Faculty $faculty) {
        return $faculty->programs;
    })->name('api.faculty.programs');
Route::get('/api/groups/{courseId}', [App\Http\Controllers\CourseController::class, 'getGroupsByCourse']);




    // Admin routes with middleware
    Route::middleware(['auth', 'user.access:admin'])->prefix('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        //create student
        // Student management routes
        Route::get('/students', [AdminController::class, 'index'])->name('admin.students.index');
        Route::get('/students/create', [AdminController::class, 'create'])->name('admin.students.create');
        Route::post('/students', [AdminController::class, 'store'])->name('admin.students.store');
        Route::delete('/students/{student}', [AdminController::class, 'destroy'])->name('admin.students.destroy');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'createCourse'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::get('/admin/courses', [CourseController::class, 'index'])->name('admin.courses.index');
    Route::put('/admin/courses/{id}', [CourseController::class, 'update'])->name('admin.courses.update');
    Route::patch('/students/{student}/scholarship', [StudentController::class, 'updateScholarshipStatus'])->name('students.scholarship.update');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::get('/admin/timetables', [AdminTimetableController::class, 'index'])->name('admin.timetables.index');
    Route::post('/admin/timetables', [AdminTimetableController::class, 'store'])->name('admin.timetables.store');
    Route::get('/admin/timetables/{id}/edit', [AdminTimetableController::class, 'edit'])->name('admin.timetables.edit');
    Route::put('/admin/timetables/{id}', [AdminTimetableController::class, 'update'])->name('admin.timetables.update');
    Route::delete('/admin/timetables/{id}', [AdminTimetableController::class, 'destroy'])->name('admin.timetables.destroy');
    Route::get('/admin/timetables/show', [AdminTimetableController::class, 'showTimetables'])->name('admin.timetables.show');
    Route::get('/admin/lecturers/create', [LecturerController::class, 'createLecturer'])->name('admin.lecturers.create');
    Route::post('/admin/lecturers', [LecturerController::class, 'store'])->name('admin.lecturers.store');
    Route::get('/admin/lecturers/{id}/edit', [LecturerController::class, 'edit'])->name('admin.lecturers.edit');
    Route::put('/admin/lecturers/{id}', [LecturerController::class, 'update'])->name('admin.lecturers.update');
    Route::delete('/admin/lecturers/{id}', [LecturerController::class, 'destroy'])->name('admin.lecturers.destroy');
            // News routes
            Route::get('/admin/news', [NewsController::class, 'index'])->name('news.index');
            Route::get('/admin/news/create', [NewsController::class, 'create'])->name('news.create');
            Route::post('/admin/news', [NewsController::class, 'store'])->name('news.store');
            Route::get('/admin/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
            Route::put('/admin/news/{id}', [NewsController::class, 'update'])->name('news.update');
            Route::delete('/admin/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
        Route::get('admin/program-structures', [ProgramStructureController::class, 'index'])->name('admin.program-structures.index');
        Route::post('admin/program-structures', [ProgramStructureController::class, 'store'])->name('admin.program-structures.store');
        Route::get('admin/program-structures/create', [ProgramStructureController::class, 'create'])->name('admin.program-structures.create');
        Route::post('admin/program-structures/{id}/toggle-status', [ProgramStructureController::class, 'toggleStatus'])
        ->name('admin.program-structures.toggle-status');
        Route::get('/get-programs/{facultyId}', [ProgramStructureController::class, 'getPrograms'])
        ->name('get-programs');
        Route::get('/admin/program-structures/list', [ProgramStructureController::class, 'list'])
        ->name('admin.program-structures.list');
        Route::get('/admin/academic-periods', [AcademicPeriodController::class, 'index'])->name('admin.academic-periods.index');
        Route::get('/admin/academic-periods/create', [AcademicPeriodController::class, 'create'])->name('admin.academic-periods.create');
        Route::post('/admin/academic-periods', [AcademicPeriodController::class, 'store'])->name('admin.academic-periods.store');
        Route::get('/admin/academic-periods/{id}/edit', [AcademicPeriodController::class, 'edit'])->name('admin.academic-periods.edit');
        Route::put('/admin/academic-periods/{id}', [AcademicPeriodController::class, 'update'])->name('admin.academic-periods.update');
        Route::delete('/admin/academic-periods/{id}', [AcademicPeriodController::class, 'destroy'])->name('admin.academic-periods.destroy');
    Route::get('/admin/registration-periods/create', [RegistrationPeriodController::class, 'create'])
    ->name('admin.registration-periods.create');
    Route::post('/admin/registration-periods', [RegistrationPeriodController::class, 'store'])
    ->name('admin.registration-periods.store');
    Route::get('/admin/registration-periods', [RegistrationPeriodController::class, 'index'])
    ->name('admin.registration-periods.index');
    Route::get('registration-periods/create', [RegistrationPeriodController::class, 'create'])
    ->name('registration-periods.create');
    Route::get('/admin/registration-periods/{registrationPeriod}/edit', [RegistrationPeriodController::class, 'edit'])
    ->name('admin.registration-periods.edit');
    Route::put('/admin/registration-periods/{registrationPeriod}', [RegistrationPeriodController::class, 'update'])
    ->name('admin.registration-periods.update');
    Route::delete('/admin/registration-periods/{registrationPeriod}', [RegistrationPeriodController::class, 'destroy'])
    ->name('admin.registration-periods.destroy');

     // Route::get('registration-periods/create', [RegistrationPeriodController::class, 'create'])->name('registration-periods.create');


    // Course Registration Routes

    Route::post('/students/{id}/courses/register', [StudentController::class, 'registerCourse'])->name('courses.register');
    Route::post('/student/register-courses', [StudentController::class, 'registerCourses'])->name('student.registerCourses');
    Route::post('/student/register-courses/submit', [StudentController::class, 'submitRegisterCourses'])->name('student.registerCourses.submit');
    Route::get('/student/register-major-courses', [StudentController::class, 'showMajorRegistration'])->name('student.registerMajorCourses');
    Route::get('/student/register-major-courses/{user_id}', [CourseController::class, 'showMajorCourseRegistration']);
    Route::post('/student/register-major-courses/submit', [CourseController::class, 'submitMajorCourses'])->name('student.registerMajorCourses.submit');
    Route::get('/students/{id}/major-registration', [CourseRequestController::class, 'showRegistrationForm'])->middleware('auth');
    Route::post('/students/{id}/courses/register', [StudentController::class, 'registerCourse'])->name('courses.register');
    Route::post('/students/{id}/courses/register', [CourseRequestController::class, 'registerCourse'])->name('courses.register');
    Route::post('/course-requests/store', [CourseRequestController::class, 'store'])->name('course-requests.store'); // Adjust as necessary
    Route::post('/admin/enrollments/{id}/reject', [EnrollmentController::class, 'reject'])->name('admin.enrollments.reject');
    Route::post('/admin/enrollments/{id}/approve', [EnrollmentController::class, 'approve'])->name('admin.enrollments.approve');
    Route::get('/course-prerequisites/{id}', [CourseController::class, 'showPrerequisites'])->name('course.prerequisites');
    Route::get('/students/{id}/status', [StudentController::class, 'getStatus'])->name('students.status');
    Route::get('/courses/{course}/group', [CourseController::class, 'getGroupInfo']);

    //admin major course registration
    // GET route for viewing course requests
    Route::get('/course-requests', [CourseRequestController::class, 'index'])
    ->name('admin.course-requests.index');

    // POST route for creating course requests
    Route::post('/course-requests', [CourseRequestController::class, 'store'])
    ->name('course-requests.store');

    // Other course request routes...
    Route::post('/course-requests/{id}/approve', [CourseRequestController::class, 'approve'])
    ->name('admin.course-requests.approve');
    Route::post('/course-requests/{id}/reject', [CourseRequestController::class, 'reject'])
    ->name('admin.course-requests.reject');




    });






// Course Request & Minor Request Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/course-requests', [CourseRequestController::class, 'index'])->name('admin.course-requests.index');
    Route::post('/course-requests/{id}/approve', [CourseRequestController::class, 'approve'])->name('admin.course-requests.approve');
    Route::post('/course-requests/{id}/reject', [CourseRequestController::class, 'reject'])->name('admin.course-requests.reject');
    Route::get('/course-requests/{id}/view', [CourseRequestController::class, 'view'])->name('admin.course-requests.view');
    Route::get('/course-requests/{id}/edit', [CourseRequestController::class, 'edit'])->name('admin.course-requests.edit');
    Route::put('/course-requests/{id}', [CourseRequestController::class, 'update'])->name('admin.course-requests.update');
    Route::delete('/course-requests/{id}', [CourseRequestController::class, 'destroy'])->name('admin.course-requests.destroy');
    Route::post('/course-requests', [CourseRequestController::class, 'store'])->name('course-requests.store');
    Route::post('/students/{id}/courses/register', [CourseRequestController::class, 'registerCourse'])->name('courses.register');
    Route::post('/course-requests/store', [CourseRequestController::class, 'store'])->name('course-requests.store');
    Route::get('/admin/enrollments/approved', [EnrollmentController::class, 'approved'])->name('admin.enrollments.approved');
    Route::get('/admin/enrollments/rejected', [EnrollmentController::class, 'rejected'])->name('admin.enrollments.rejected');
    Route::post('/course_requests/approve/{id}', [CourseRequestController::class, 'approve'])->name('course_requests.approve');
    Route::post('/course_requests/reject/{id}', [CourseRequestController::class, 'reject'])->name('course_requests.reject');
    Route::post('/admin/course-requests/{id}/approve', [CourseRequestController::class, 'approve'])->name('course-requests.approve');
    Route::post('/admin/course-requests/{id}/reject', [CourseRequestController::class, 'reject'])->name('course-requests.reject');

});

// Student routes with middleware
Route::middleware(['auth', 'user.access:student'])->group(function () {
    Route::get('/students/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    // Student profile routes
    Route::get('/student/profile/{id}', [StudentController::class, 'show'])->name('students.profile');
    Route::get('/student/profile/{id}/edit', [StudentController::class, 'edit'])->name('student.profile.edit');
    Route::put('/student/profile/{id}', [StudentController::class, 'update'])->name('student.profile.update');// Student edit route
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    // Enrollment status routes
    Route::get('/students/enrollment-status/{id}/view', [StudentController::class, 'showEnrollmentStatus'])->name('students.enrollment-status.view');
    Route::get('/students/enrollment-status/{id}', [StudentController::class, 'showEnrollmentStatus'])->name('students.enrollment-status');
    Route::get('/students/enrollment-status', [StudentController::class, 'showEnrollmentStatus'])->name('students.enrollment-status');
    Route::get('/students/status-enrollment', [StudentController::class, 'showEnrollmentStatus'])->name('students.status-enrollment');
    Route::get('/students/{id}/enrollment-status', [StudentController::class, 'showEnrollmentStatus'])->name('students.enrollment-status');
    Route::post('/students/{id}/courses/register', [StudentController::class, 'registerCourse'])->name('courses.register');

    //new major course registration
    Route::get('/major-registration', [CourseRequestController::class, 'showRegistrationForm'])
    ->name('student.major-registration');
    // Only protect the store route with registration period check
    Route::post('/course-requests', [CourseRequestController::class, 'store'])
    ->middleware('check.major.registration')
    ->name('course-requests.store');



    Route::get('/students/status-enrollment', [StudentController::class, 'showEnrollmentStatus'])->name('students.status-enrollment');
    Route::get('/student/enrollment-status', [StudentController::class, 'showEnrollmentStatus'])->name('student.enrollment-status');
    Route::get('/student/timetable', [StudentController::class, 'showTimetable'])->name('student.timetable');
    Route::get('/enrollment-status', [StudentController::class, 'showEnrollmentStatus'])->name('student.enrollment-status');
    Route::get('student/program-structure', [ProgramStructureController::class, 'show'])->name('student.program-structure');
    Route::get('program-structure/download', [ProgramStructureController::class, 'download'])->name('student.program-structure.download');

    // Minor Registration Routes - Update these routes
    Route::get('/student/minor-registration', [MinorRegistrationController::class, 'create'])
    ->name('student.minor-registration.create')
    ->middleware('check.registration:minor');

    Route::post('/student/minor-registration', [MinorRegistrationController::class, 'store'])
    ->name('student.minor-registration.store')
    ->middleware('check.registration:minor');

    Route::post('/student/minor-registration/generate-pdf', [MinorRegistrationController::class, 'generatePdf'])
    ->name('student.minor-registration.generate-pdf');

    Route::patch('/student/minor-registration/{minorRegistration}/cancel', [MinorRegistrationController::class, 'cancel'])
    ->name('student.minor-registration.cancel');

    Route::delete('/student/minor-registration/{minorRegistration}', [MinorRegistrationController::class, 'destroy'])
    ->name('student.minor-registration.destroy');
});





Route::get('/course-prerequisites/{courseId}', [CourseController::class, 'getPrerequisites']);


Route::get('/course/{id}', function ($id) {
    $course = Course::find($id);
    $prerequisites = $course->prerequisites;

    return view('courses.show', compact('course', 'prerequisites'));
});

Route::get('/test-prerequisites', function () {
    $course = App\Models\Course::with('prerequisites')->first(); // Get the first course with prerequisites
    return $course->prerequisites; // This should return the prerequisites
});

Route::get('/course-prerequisites/{courseId}', [CourseController::class, 'getPrerequisites']);

Route::resource('courses', CourseController::class);
Route::resource('lecturers', LecturerController::class);
Route::resource('events', EventController::class);
Route::resource('program-structures', ProgramStructureController::class);
Route::resource('academic-periods', AcademicPeriodController::class);
Route::resource('registration-periods', RegistrationPeriodController::class);







Route::middleware(['auth', 'is_dean'])->group(function () {
    Route::get('/dean/dashboard', [DeanController::class, 'dashboard'])
        ->name('dean.dashboard');
    // Minor registration routes
    // Minor registration routes
    Route::get('/dean/minor-requests', [MinorRegistrationController::class, 'index'])
    ->name('dean.minor-requests.index');
    Route::get('/dean/minor-requests/{minorRegistration}/review', [MinorRegistrationController::class, 'showRecommendation'])
    ->name('dean.minor-requests.review');
    Route::put('/dean/minor-requests/{minorRegistration}/recommendation', [MinorRegistrationController::class, 'updateRecommendation'])
    ->name('dean.minor-requests.recommendation');

    // ... other dean routes
});

Route::middleware(['auth'])->group(function () {
    Route::resource('news', NewsController::class);
});

// Make sure this is OUTSIDE any other route groups
Route::get('/admin/get-programs/{faculty}', [ProgramStructureController::class, 'getPrograms'])
    ->name('admin.get-programs');

// Your other admin routes...
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/program-structures', [ProgramStructureController::class, 'index'])->name('program-structures.index');
    // ... other routes
});

// Add this to your web.php routes file
Route::middleware(['auth', 'check.major.registration'])->group(function () {
    Route::get('/major-course-registration', [CourseRequestController::class, 'showRegistrationForm'])
        ->name('student.major-course-registration');
    Route::post('/course-requests', [CourseRequestController::class, 'store'])
        ->name('course-requests.store');
});

// Add this at the bottom of your routes file
Route::get('/debug-routes', function() {
    dd(Route::getRoutes()->get('GET'));
});

// Admin routes
Route::middleware(['auth', 'user.access:admin'])->group(function () {
    Route::get('/admin/course-requests', [CourseRequestController::class, 'index'])
        ->name('admin.course-requests.index');
});

// Student routes
Route::middleware(['auth', 'user.access:student'])->group(function () {
    Route::get('/major-registration', [CourseRequestController::class, 'showRegistrationForm'])
        ->name('student.major-registration');
    Route::post('/course-requests', [CourseRequestController::class, 'store'])
        ->name('course-requests.store');
});

Route::any('/test-route', function(Request $request) {
    dd([
        'method' => $request->method(),
        'url' => $request->url(),
        'intended_url' => $request->intended(),
        'all_routes' => Route::getRoutes()->get($request->method()),
    ]);
});


// Debug routes
Route::get('/debug-routes', function () {
    dd([
        'GET_routes' => collect(Route::getRoutes()->get('GET'))->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'middleware' => $route->middleware()
            ];
        }),
        'auth_status' => auth()->check(),
        'user' => auth()->user()
    ]);
});

Route::get('/debug-files', function () {
    $files = Storage::disk('public')->files('minor-registrations');
    $allFiles = Storage::disk('public')->allFiles();

    return [
        'minor_registration_files' => $files,
        'all_files' => $allFiles,
        'storage_path' => storage_path(),
        'public_path' => public_path(),
        'storage_link_exists' => file_exists(public_path('storage')),
    ];
});

// Temporary debug route
Route::get('/debug-storage', function () {
    $path = 'minor-registrations/GZqIzhntWD4DK8R5bNBRznmQWZjr1zRZvin1rp2k.pdf';

    $debug = [
        'Current Directory' => getcwd(),
        'Storage Path Details' => [
            'storage_path()' => storage_path(),
            'public_path()' => public_path(),
            'base_path()' => base_path(),
        ],
        'Symlink Check' => [
            'public/storage exists' => file_exists(public_path('storage')),
            'storage/app/public exists' => file_exists(storage_path('app/public')),
        ],
        'File Check' => [
            'Direct file_exists' => file_exists(storage_path('app/public/' . $path)),
            'Storage::exists' => Storage::disk('public')->exists($path),
            'Storage::path' => Storage::disk('public')->path($path),
            'Real path (storage)' => realpath(storage_path('app/public/' . $path)),
            'Real path (public)' => realpath(public_path('storage/' . $path)),
        ],
        'Directory Contents' => [
            'storage/app/public/minor-registrations' => is_dir(storage_path('app/public/minor-registrations'))
                ? array_diff(scandir(storage_path('app/public/minor-registrations')), ['.', '..'])
                : 'Directory does not exist',
            'public/storage/minor-registrations' => is_dir(public_path('storage/minor-registrations'))
                ? array_diff(scandir(public_path('storage/minor-registrations')), ['.', '..'])
                : 'Directory does not exist',
        ],
    ];

    dd($debug);
});


