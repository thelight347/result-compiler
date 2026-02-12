<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Subject Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('subjects.edit', $subject) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Subject
                </a>
                <a href="{{ route('subjects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Subject Information Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Subject Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Subject Code</label>
                            <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $subject->code }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Subject Name</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $subject->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Class</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $subject->class }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Teacher</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $subject->teacher_name ?? 'Not Assigned' }}</p>
                        </div>

                        @if($subject->description)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500">Description</label>
                            <p class="mt-1 text-gray-900">{{ $subject->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Enrolled Students -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Enrolled Students 
                        <span class="text-sm font-normal text-gray-500">({{ $subject->results->count() }} students)</span>
                    </h3>
                    @if($subject->results->isEmpty())
                        <p class="text-gray-500 text-center py-4">No students enrolled yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Admission No.</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Latest Score</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($subject->results->unique('student_id') as $result)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $result->student->admission_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $result->student->full_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $result->student->class }} {{ $result->student->section }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $result->total_score }}/100
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $result->grade === 'A' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $result->grade === 'B' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $result->grade === 'C' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ in_array($result->grade, ['D', 'E', 'F']) ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ $result->grade }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('students.show', $result->student) }}" class="text-blue-600 hover:text-blue-900">
                                                    View Student
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>