<?php
use App\Models\ClassRoom;
use App\Models\ClassRoomUnit;
use App\Models\Exam;
use App\Models\Mark;
use Livewire\Volt\Component;

new class extends Component {
    public $classRoom;
    public $classRoomUnit;
    public $exam;
    public $students;
    public $studentScores = [];

    public function mount($classRoomId, $classRoomUnitId, $examId) {
        $this->classRoom = ClassRoom::findOrFail($classRoomId);
        $this->classRoomUnit = ClassRoomUnit::findOrFail($classRoomUnitId);
        $this->exam = Exam::findOrFail($examId);
        $this->students = $this->classRoom->students;

        foreach ($this->students as $student) {
            $this->studentScores[$student->id] = [
                'student_score' => '',
                'maximum_score' => '',
                'percentage_score' => '',
            ];
        }
    }

    public function calculatePercentage($studentId) {
        $score = $this->studentScores[$studentId]['student_score'];
        $max = $this->studentScores[$studentId]['maximum_score'];

        if ($score !== '' && $max !== '' && $max > 0) {
            $percentage = ($score / $max) * 100;
            $this->studentScores[$studentId]['percentage_score'] = number_format($percentage, 2) . '%';
        } else {
            $this->studentScores[$studentId]['percentage_score'] = '';
        }
    }

    public function saveMarks($studentId)
    {
        $this->validate([
            "studentScores.{$studentId}.student_score" => 'required|numeric',
            "studentScores.{$studentId}.maximum_score" => 'required|numeric|gt:0',
        ]);

        try {
            Mark::updateOrCreate(
                [
                    'exam_id' => $this->exam->id,
                    'student_id' => $studentId,
                    'class_room_unit_id' => $this->classRoomUnit->id,
                ],
                [
                    'student_score' => $this->studentScores[$studentId]['student_score'],
                    'maximum_score' => $this->studentScores[$studentId]['maximum_score'],
                    'percentage_score' => $this->studentScores[$studentId]['percentage_score'],
                ]
            );

            $this->dispatch('marksUpdated');
            session()->flash('message', 'Score saved successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving score: ' . $e->getMessage());
        }
    }
};

?>


<div class="bg-gray-100 min-h-screen py-8">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Exam Scores</h1>

            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-100 p-4 rounded-lg">
                    <h2 class="font-semibold text-blue-800">ClassRoom</h2>
                    <p class="text-blue-600">{{ $classRoom->name }}</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <h2 class="font-semibold text-green-800">Unit</h2>
                    <p class="text-green-600">{{ $classRoomUnit->name }}</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-lg">
                    <h2 class="font-semibold text-purple-800">Exam</h2>
                    <p class="text-purple-600">{{ $exam->name }}</p>
                </div>
            </div>


            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left">Student Name</th>
                            <th class="py-3 px-4 text-left">Student Score</th>
                            <th class="py-3 px-4 text-left">Maximum Score</th>
                            <th class="py-3 px-4 text-left">Percentage Score</th>
                            <th class="py-3 px-4 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach ($students as $student)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $student->name }}</td>
                                <td class="py-3 px-4">
                                    <input type="number"
                                           wire:model.live="studentScores.{{ $student->id }}.student_score"
                                           wire:change="calculatePercentage({{ $student->id }})"
                                           placeholder="e.g. 23"
                                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                                </td>
                                <td class="py-3 px-4">
                                    <input type="number"
                                           wire:model.live="studentScores.{{ $student->id }}.maximum_score"
                                           wire:change="calculatePercentage({{ $student->id }})"
                                           placeholder="e.g. 50"
                                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                                </td>
                                <td class="py-3 px-4">
                                    <input type="text"
                                           wire:model="studentScores.{{ $student->id }}.percentage_score"
                                           readonly
                                           placeholder="e.g. 78%"
                                           class="w-full px-3 py-2 bg-gray-100 border rounded-md">
                                </td>
                                <td class="py-3 px-4">
                                    <button wire:click="saveMarks({{ $student->id }})"
                                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 transition duration-150 ease-in-out">
                                        Save Score
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
