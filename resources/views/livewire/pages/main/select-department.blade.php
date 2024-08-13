<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use App\Models\Department;
use App\Models\Course;
use App\Models\{ClassRoom, ClassRoomUnit, Exam};

new
#[Title('Tetu Exams - Add Student Marks')]
class extends Component
{
    public $departments = [];
    public $courses = [];
    public $classRooms = [];
    public $classRoomUnits = [];
    public $exams = [];

    public $selectedDepartment = '';
    public $selectedCourse = '';
    public $selectedClassRoom = '';
    public $selectedClassRoomUnit = '';
    public $selectedExam = '';

    public function mount()
    {
        $this->departments = Department::orderBy('name')->get();
    }

    public function setDepartment()
    {
        $this->courses = Course::where('department_id', $this->selectedDepartment)->orderBy('name')->get();
        $this->reset(['selectedCourse', 'selectedClassRoom', 'selectedClassRoomUnit', 'selectedExam']);
    }

    public function setCourse()
    {
        $this->classRooms = ClassRoom::where('course_id', $this->selectedCourse)->orderBy('name')->get();
        $this->reset(['selectedClassRoom', 'selectedClassRoomUnit', 'selectedExam']);
    }

    public function setClassRoom()
    {
        $this->classRoomUnits = ClassRoomUnit::where('class_room_id', $this->selectedClassRoom)->orderBy('name')->get();
        $this->reset(['selectedClassRoomUnit', 'selectedExam']);
    }

    public function setClassRoomUnit()
    {
        $this->exams = Exam::orderBy('name')->get();
        $this->reset('selectedExam');
    }

    public function goToAddMarks()
    {
        $this->validate([
            'selectedDepartment' => 'required',
            'selectedCourse' => 'required',
            'selectedClassRoom' => 'required',
            'selectedClassRoomUnit' => 'required',
            'selectedExam' => 'required',
        ]);

        return redirect()->route('add.scores', [
            'classRoomId' => $this->selectedClassRoom,
            'classRoomUnitId' => $this->selectedClassRoomUnit,
            'examId' => $this->selectedExam,
        ]);
    }
}
?>



<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="p-8 max-w-md w-full bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-center text-indigo-600 mb-6">Tetu Exams</h1>
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Add Student Marks</h2>
        <form wire:submit.prevent="goToAddMarks">
            <div class="space-y-4">
                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                    <select wire:model="selectedDepartment" wire:change="setDepartment" id="department" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Select a Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="course" class="block text-sm font-medium text-gray-700">Course</label>
                    <select wire:model="selectedCourse" wire:change="setCourse" id="course" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" {{ empty($selectedDepartment) ? 'disabled' : '' }}>
                        <option value="">Select a Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="classRoom" class="block text-sm font-medium text-gray-700">Class Room</label>
                    <select wire:model="selectedClassRoom" wire:change="setClassRoom" id="classRoom" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" {{ empty($selectedCourse) ? 'disabled' : '' }}>
                        <option value="">Select a Class Room</option>
                        @foreach ($classRooms as $classRoom)
                            <option value="{{ $classRoom->id }}">{{ $classRoom->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="classRoomUnit" class="block text-sm font-medium text-gray-700">Exam Unit</label>
                    <select wire:model="selectedClassRoomUnit" wire:change="setClassRoomUnit" id="classRoomUnit" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" {{ empty($selectedClassRoom) ? 'disabled' : '' }}>
                        <option value="">Select an Exam Unit</option>
                        @foreach ($classRoomUnits as $classRoomUnit)
                            <option value="{{ $classRoomUnit->id }}">{{ $classRoomUnit->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="exam" class="block text-sm font-medium text-gray-700">Exam</label>
                    <select wire:model="selectedExam" id="exam" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" {{ empty($selectedClassRoomUnit) ? 'disabled' : '' }}>
                        <option value="">Select an Exam</option>
                        @foreach ($exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Go To Add Marks
                </button>
            </div>
        </form>
    </div>
</div>
