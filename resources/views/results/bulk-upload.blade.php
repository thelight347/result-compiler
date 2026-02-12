{{-- resources/views/results/bulk-upload.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-upload me-2"></i>Bulk Upload Results
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-file-upload me-2"></i>Upload Multiple Results</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('results.bulk.store') }}" method="POST" id="bulkUploadForm">
                @csrf

                <!-- Term, Session & Class Selection -->
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-cog me-2"></i>General Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="term" class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt text-info me-2"></i>Term *
                                </label>
                                <select name="term" id="term" class="form-select form-select-lg @error('term') is-invalid @enderror" required>
                                    <option value="">Select Term</option>
                                    <option value="First Term">First Term</option>
                                    <option value="Second Term">Second Term</option>
                                    <option value="Third Term">Third Term</option>
                                </select>
                                @error('term')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="session" class="form-label fw-bold">
                                    <i class="fas fa-calendar-year text-warning me-2"></i>Session *
                                </label>
                                <input type="text" name="session" id="session" 
                                       class="form-control form-control-lg @error('session') is-invalid @enderror" 
                                       placeholder="e.g., 2024/2025" required>
                                @error('session')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="class" class="form-label fw-bold">
                                    <i class="fas fa-users text-primary me-2"></i>Class *
                                </label>
                                <input type="text" name="class" id="class" 
                                       class="form-control form-control-lg @error('class') is-invalid @enderror" 
                                       placeholder="e.g., JSS 1" required>
                                @error('class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-info-circle text-success me-2"></i>Filter Students
                                </label>
                                <button type="button" id="filterBtn" class="btn btn-success btn-lg w-100" onclick="filterStudentsByClass()">
                                    <i class="fas fa-filter me-2"></i>Filter by Class
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Box -->
                <div class="alert alert-info d-flex align-items-center mb-4">
                    <i class="fas fa-info-circle fa-2x me-3"></i>
                    <div>
                        <strong>Grading System:</strong> 
                        1st CA (10 marks) + 2nd CA (10 marks) + 3rd CA (10 marks) + Exam (70 marks) = Total (100 marks)
                    </div>
                </div>

                <!-- Results Entry Table -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-dark mb-0">
                            <i class="fas fa-table me-2"></i>Enter Student Results
                        </h6>
                        <button type="button" onclick="addResultRow()" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-2"></i>Add Student
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="resultsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th style="width: 220px;">Student</th>
                                    <th style="width: 200px;">Subject</th>
                                    <th style="width: 80px;" class="text-center">1st CA<br><small>(10)</small></th>
                                    <th style="width: 80px;" class="text-center">2nd CA<br><small>(10)</small></th>
                                    <th style="width: 80px;" class="text-center">3rd CA<br><small>(10)</small></th>
                                    <th style="width: 80px;" class="text-center">CA Total<br><small>(30)</small></th>
                                    <th style="width: 80px;" class="text-center">Exam<br><small>(70)</small></th>
                                    <th style="width: 80px;" class="text-center">Total<br><small>(100)</small></th>
                                    <th style="width: 60px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="resultsTableBody">
                                <!-- Initial row -->
                                <tr class="result-row">
                                    <td class="text-center align-middle fw-bold">1</td>
                                    <td>
                                        <select name="results[0][student_id]" class="form-select form-select-sm student-select" required>
                                            <option value="">Select Student</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" data-class="{{ $student->class }}">
                                                    {{ $student->admission_number }} - {{ $student->full_name }} ({{ $student->class }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="results[0][subject_id]" class="form-select form-select-sm subject-select" required>
                                            <option value="">Select Subject</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">
                                                    {{ $subject->name }} ({{ $subject->code }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="results[0][ca1_score]" 
                                               class="form-control form-control-sm text-center ca1-score" 
                                               min="0" max="10" step="0.01" 
                                               placeholder="0" required onchange="calculateTotal(this)">
                                    </td>
                                    <td>
                                        <input type="number" name="results[0][ca2_score]" 
                                               class="form-control form-control-sm text-center ca2-score" 
                                               min="0" max="10" step="0.01" 
                                               placeholder="0" required onchange="calculateTotal(this)">
                                    </td>
                                    <td>
                                        <input type="number" name="results[0][ca3_score]" 
                                               class="form-control form-control-sm text-center ca3-score" 
                                               min="0" max="10" step="0.01" 
                                               placeholder="0" required onchange="calculateTotal(this)">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm text-center ca-total bg-light fw-bold" 
                                               readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="results[0][exam_score]" 
                                               class="form-control form-control-sm text-center exam-score" 
                                               min="0" max="70" step="0.01" 
                                               placeholder="0" required onchange="calculateTotal(this)">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm text-center total-score bg-primary text-white fw-bold" 
                                               readonly>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="button" onclick="removeRow(this)" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                <h6 class="mb-0">Total Students</h6>
                                <p class="text-muted mb-0" id="totalStudents">1</p>
                            </div>
                            <div class="col-md-3 border-start">
                                <i class="fas fa-calculator fa-2x text-success mb-2"></i>
                                <h6 class="mb-0">Average Score</h6>
                                <p class="text-muted mb-0" id="averageScore">0.00</p>
                            </div>
                            <div class="col-md-3 border-start">
                                <i class="fas fa-chart-line fa-2x text-warning mb-2"></i>
                                <h6 class="mb-0">Highest Score</h6>
                                <p class="text-muted mb-0" id="highestScore">0.00</p>
                            </div>
                            <div class="col-md-3 border-start">
                                <i class="fas fa-chart-bar fa-2x text-danger mb-2"></i>
                                <h6 class="mb-0">Lowest Score</h6>
                                <p class="text-muted mb-0" id="lowestScore">0.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('results.index') }}" class="btn btn-secondary btn-lg px-4">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-upload me-2"></i>Upload Results
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    let rowIndex = 1;
    let allStudents = @json($students);

    function addResultRow() {
        const tbody = document.getElementById('resultsTableBody');
        const newRow = tbody.querySelector('.result-row').cloneNode(true);
        
        // Update row number
        newRow.querySelector('td:first-child').textContent = rowIndex + 1;
        
        // Update input names
        newRow.querySelectorAll('input, select').forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIndex}]`));
            }
            // Clear values except readonly fields
            if (!input.hasAttribute('readonly')) {
                input.value = '';
            } else {
                input.value = '0.00';
            }
        });
        
        tbody.appendChild(newRow);
        rowIndex++;
        updateSummary();
    }

    function removeRow(button) {
        const tbody = document.getElementById('resultsTableBody');
        if (tbody.querySelectorAll('.result-row').length > 1) {
            button.closest('tr').remove();
            updateRowNumbers();
            updateSummary();
        } else {
            alert('Cannot remove the last row!');
        }
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('.result-row');
        rows.forEach((row, index) => {
            row.querySelector('td:first-child').textContent = index + 1;
        });
    }

    function calculateTotal(input) {
        const row = input.closest('tr');
        const ca1 = parseFloat(row.querySelector('.ca1-score').value) || 0;
        const ca2 = parseFloat(row.querySelector('.ca2-score').value) || 0;
        const ca3 = parseFloat(row.querySelector('.ca3-score').value) || 0;
        const exam = parseFloat(row.querySelector('.exam-score').value) || 0;
        
        const caTotal = ca1 + ca2 + ca3;
        const total = caTotal + exam;
        
        row.querySelector('.ca-total').value = caTotal.toFixed(2);
        row.querySelector('.total-score').value = total.toFixed(2);
        
        updateSummary();
    }

    function updateSummary() {
        const rows = document.querySelectorAll('.result-row');
        const totals = [];
        
        rows.forEach(row => {
            const total = parseFloat(row.querySelector('.total-score').value) || 0;
            if (total > 0) totals.push(total);
        });
        
        document.getElementById('totalStudents').textContent = rows.length;
        
        if (totals.length > 0) {
            const avg = totals.reduce((a, b) => a + b, 0) / totals.length;
            const highest = Math.max(...totals);
            const lowest = Math.min(...totals);
            
            document.getElementById('averageScore').textContent = avg.toFixed(2);
            document.getElementById('highestScore').textContent = highest.toFixed(2);
            document.getElementById('lowestScore').textContent = lowest.toFixed(2);
        } else {
            document.getElementById('averageScore').textContent = '0.00';
            document.getElementById('highestScore').textContent = '0.00';
            document.getElementById('lowestScore').textContent = '0.00';
        }
    }

    function filterStudentsByClass() {
        const selectedClass = document.getElementById('class').value.trim();
        
        if (!selectedClass) {
            alert('Please enter a class first!');
            return;
        }

        const studentSelects = document.querySelectorAll('.student-select');
        
        studentSelects.forEach(select => {
            // Clear current options except the first one
            select.innerHTML = '<option value="">Select Student</option>';
            
            // Filter students by class
            allStudents.forEach(student => {
                if (student.class.toLowerCase() === selectedClass.toLowerCase()) {
                    const option = document.createElement('option');
                    option.value = student.id;
                    option.setAttribute('data-class', student.class);
                    option.textContent = `${student.admission_number} - ${student.first_name} ${student.middle_name || ''} ${student.last_name} (${student.class})`;
                    select.appendChild(option);
                }
            });
        });

        // Show success message
        const filteredCount = document.querySelectorAll('.student-select option').length - 1;
        if (filteredCount > 0) {
            alert(`Filtered ${filteredCount} students in ${selectedClass}`);
        } else {
            alert(`No students found in ${selectedClass}`);
        }
    }
</script>

<style>
.table-responsive {
    max-height: 500px;
    overflow-y: auto;
}

.table thead {
    position: sticky;
    top: 0;
    z-index: 10;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    opacity: 1;
}

.form-select-sm, .form-control-sm {
    font-size: 0.875rem;
}

.table-bordered td {
    vertical-align: middle;
}
</style>