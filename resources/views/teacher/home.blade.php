<!DOCTYPE html>
<html lang="en">
<head>
    <title>Teacher Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        h1, h3 {
            text-align: center;
        }
        h3 {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome</h1>
        <h3>Teachers Portal</h3>

        <form action="{{ route('logout') }}" method="POST" style="display:inline;float:right">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->subject }}</td>
                    <td>{{ $student->marks }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="editStudent({{ $student }}, 'edit')">Edit</a></li>
                                <li><a class="dropdown-item" href="#" onclick="deleteStudent({{ $student->id }})">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal" id="add">Add</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="studentForm" action="{{ url('/student/add') }}" method="POST">
                    @csrf
                    <input type="hidden" id="studentId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="studentName" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="studentName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="subjectName" class="form-label">Subject Name</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="marks" class="form-label">Marks</label>
                            <input type="number" class="form-control" id="marks" name="marks" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        $('#add').on('click', function() {
            document.getElementById('studentForm').reset();
        });

        function editStudent(student, action)
        {
            $('#addStudentModal').modal('show');
            $('#studentId').val(student.id || '');
            $('#studentName').val(student.name || '');
            $('#subject').val(student.subject || '');
            $('#marks').val(student.marks || '');
        }

        function deleteStudent(id)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (confirm('Are you sure you want to delete this student?')) {
                $.ajax({
                    url: "{{ url('delete-student') }}/" + id,
                    type : 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = "{{ route('teacher.home') }}";
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred: ' + xhr.responseJSON.message);
                    }

                });
            }
        }
    </script>
</body>
</html>
