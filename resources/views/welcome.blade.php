<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cool Meeting App</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add a link to a font library that includes cool symbols (e.g., Google Fonts) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <!-- Add your custom CSS styles -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        {{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Laravel</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="material-icons"></i>
                            Login</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register.index') }}"><i
                                class="material-icons"></i> Register</a>
                    </li>
                </ul>
            </div>
        </nav> --}}
        <div class="hero text-center pt-4 pb-2">
            <h1>Welcome to Techtok Meeting App</h1>
            <p>Plan, schedule, and join meetings effortlessly.</p>
        </div>
    </header>

    <main class="container">
        <section class="features text-center mt-3 mt-3">
            <h2>Features</h2>
            <div class="row">
                <div class="col-md-3">
                    <i class="material-icons">event</i>
                    <p>Create and schedule meetings</p>
                </div>
                <div class="col-md-3">
                    <i class="material-icons">group</i>
                    <p>Invite participants and set agendas</p>
                </div>
                <div class="col-md-3">
                    <i class="material-icons">video_call</i>
                    <p>Join meetings with a single click</p>
                </div>
                <div class="col-md-3">
                    <i class="material-icons">chat</i>
                    <p>Chat and collaborate during meetings</p>
                </div>
            </div>
        </section>
        <section class="my-2">
            <div class="">
                <div class=" d-flex justify-content-center">
                    <a class="btn btn-primary mx-2" href="{{ route('register.index') }}"><i class="material-icons"></i>
                        Register</a>
                    <a class="btn btn-primary mx-2" href="{{ route('login') }}"><i class=""></i>
                        Login</a>
                </div>
            </div>
        </section>
        <section class="upcoming-meetings my-5">
            <h2>Upcoming Meetings</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title">Team Meeting</h3>
                            <p class="card-text"><i class="material-icons">calendar_today</i> Date: November 10, 2023
                            </p>
                            <p class="card-text"><i class="material-icons">access_time</i> Time: 10:00 AM</p>
                            <a href="#" class="btn btn-primary"><i class="material-icons">video_call</i> Join</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title">Project Review</h3>
                            <p class="card-text"><i class="material-icons">calendar_today</i> Date: November 12, 2023
                            </p>
                            <p class="card-text"><i class="material-icons">access_time</i> Time: 2:00 PM</p>
                            <a href="#" class="btn btn-primary"><i class="material-icons">video_call</i> Join</a>
                        </div>
                    </div>
                </div>
        </section>
    </main>

    <!-- Link to Bootstrap JS and jQuery (required for Bootstrap functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</html>
