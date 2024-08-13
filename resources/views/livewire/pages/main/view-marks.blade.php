<?php
use App\Models\ClassRoom;
use App\Models\ClassRoomUnit;
use App\Models\Exam;
use App\Models\Mark;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {

    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $classRoom;
    public $classRoomUnit;
    public $exam;
    public $marks = [];

    public function mount($classRoomId, $classRoomUnitId, $examId) {
        $this->classRoom = ClassRoom::findOrFail($classRoomId);
        $this->classRoomUnit = ClassRoomUnit::findOrFail($classRoomUnitId);
        $this->exam = Exam::findOrFail($examId);


        $this->marks = Mark::where('class_room_unit_id', $classRoomUnitId)
                    ->where('exam_id', $examId)
                    ->with('student')
                    ->get();  // Returns paginated results


    }

}; ?>

<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Students with Exam Scores</h1>

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

            @if($marks->isEmpty())
                <p class="text-gray-600 text-center py-4">No students have marks for this unit and exam yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-3 px-4 text-left">Student Name</th>
                                <th class="py-3 px-4 text-left">Student Score</th>
                                <th class="py-3 px-4 text-left">Maximum Score</th>
                                <th class="py-3 px-4 text-left">Percentage Score</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($marks as $mark)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ $mark->student->name }}</td>
                                    <td class="py-3 px-4">{{ $mark->student_score }}</td>
                                    <td class="py-3 px-4">{{ $mark->maximum_score }}</td>
                                    <td class="py-3 px-4">{{ $mark->percentage_score }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif


            {{-- <div class="mt-4">
                {{ $marks->links() }}
            </div>

            <div class="mt-6">
                <a href="{{ route('add.scores', ['classRoomId' => $classRoom->id, 'classRoomUnitId' => $classRoomUnit->id, 'examId' => $exam->id]) }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Enter Scores for Remaining Students
                </a>
            </div> --}}
        </div>
    </div>
</div>
