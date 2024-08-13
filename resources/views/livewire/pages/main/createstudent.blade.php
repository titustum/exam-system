<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;

use App\Models\Student;
use App\Models\Department;
use App\Models\Course;
use App\Models\ClassRoom;

new
#[Title('Create Student Page')]
class extends Component {

    public string $name = '';
    public string $admission_number = '';
    public string $gender = '';
    public string $department_id = '';
    public string $course_id = '';
    public string $class_room_id = '';
    public string $feedback_message = '';

    public $departments = [];
    public $courses = [];
    public $class_rooms = [];


    public function mount(){
        $this->departments = Department::get();
        $this->courses = Course::get();
        $this->class_rooms = ClassRoom::get();
    }


    public function admitStudent(): void
    {
        $validated = $this->validate([
            'admission_number' => ['required', 'numeric', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'numeric', 'max:255'],
            'course_id' => ['required', 'numeric', 'max:255'],
            'class_room_id' => ['required', 'numeric', 'max:255']
        ]);

        Student::create($validated);

        $this->feedback_message = "{$this->name} added successfully!";

        // $this->reset('admission_number', 'name', 'gender');

    }

};

?>

<div>






    <form class="max-w-lg mx-auto mt-20 space-y-2 p-4 rounded-md border" wire:submit="admitStudent">

        @if ($feedback_message)
        <div class="p-2 rounded-md bg-green-100 text-green-600">
            {{ $feedback_message }}
        </div>
        @endif

        <h1 class="py-8 text-3xl font-bold text-center">Create new student</h1>

        <!-- Admission Number -->
        <div>
            <x-input-label for="admission_number" :value="__('Admission Number')" />
            <x-text-input wire:model="admission_number" id="admission_number" class="block mt-1 w-full" type="number" name="admission_number" required autofocus autocomplete="admission_number" />
            <x-input-error :messages="$errors->get('admission_number')" class="mt-2" />
        </div>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <!-- Gender -->
        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select wire:model="gender" id="gender" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="text" name="gender" required>
                <option value="">Choose ...</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>
        <!-- Department -->
        <div>
            <x-input-label for="department_id" :value="__('Department')" />
            <select wire:model="department_id" id="department_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="department_id" required>
                <option value="">Choose ...</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
        </div>
        <!-- Course -->
        <div>
            <x-input-label for="course_id" :value="__('Course')" />
            <select wire:model="course_id" id="course_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="course_id" required>
                <option value="">Choose ...</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
        </div>
        <!-- Class -->
        <div>
            <x-input-label for="class_room_id" :value="__('Class')" />
            <select wire:model="class_room_id" id="class_room_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="class_room_id" required>
                <option value="">Choose ...</option>
                @foreach ($class_rooms as $class_room)
                    <option value="{{ $class_room->id }}">{{ $class_room->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('class_room_id')" class="mt-2" />
        </div>


        <x-primary-button class="ms-4">
            {{ __('CREAT NEW STUDENT') }}
        </x-primary-button>


    </form>

</div>
