<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-12">
                <h4><i class="fas fa-exam"></i> {{ $exam['name'] }}</h4>
            </div>
            <div class="col-12">
                <!-- Display the countdown timer in an element -->
                <span class="badge badge-danger" id="timer"></span>
            </div>
        </div>
    </div>
    @foreach ($questions as $question)
    <div class="card-body">
        <p><font size="6" > {{ $question['option_A'] }} {{ $question['option_B'] }} {{ $question['option_C'] }} {{ $question['option_D'] }} {{ $question['option_E'] }}</font></p>
        <p><b>Soal     </b><font size="6" >{{ $question['detail'] }}</font></p>
            @if ($question['video_id'])
                <video width="320" height="240" controls>
                    <source src="{{ Storage::url('public/videos/'.$video->getLink($question['video_id'])) }}" type="video/mp4">
                    <source src="{{ Storage::url('public/videos/'.$video->getLink($question['video_id'])) }}" type="video/mpeg">
                </video>
            @elseif($question['audio_id'])
                <audio width="160" height="120" controls>
                    <source src="{{ Storage::url('public/audios/'.$audio->getLink($question['audio_id'])) }}" type="audio/mp3">
                    <source src="{{ Storage::url('public/audios/'.$audio->getLink($question['audio_id'])) }}" type="audio/wav">
                </audio>
            @elseif($question['document_id'])
                <a href=" {{ Storage::url('public/documents/'.$document->getLink($question['document_id'])) }}">DOCUMENT</a>
            @elseif($question['image_id'])
            <img src="{{ Storage::url('public/images/'.$image->getLink($question['image_id'])) }}" style="width: 600px">
            @else
               
            @endif
        <br>
       <!-- <i>Pilih salah satu jawaban dibawah ini:</i> -->
        <br>
        <div class="card-body">
        <table align="left" style="width:100%">
            <tr>
                <th style="width:20%"><p class="text-center"><b><font size="8">  {{ $question['option_A'] }} </b></p>
                </th>
                <th style="width:20%"><p class="text-center"><b><font size="8">  {{ $question['option_B'] }} </b></p>
                </th>
                <th style="width:20%"><p class="text-center"><b><font size="8"> {{ $question['option_C'] }} </b></p>
                </th>
                <th style="width:20%"><p class="text-center"><b><font size="8"> {{ $question['option_D'] }} </b></p>
                </th>
                <th style="width:20%"><p class="text-center"><b><font size="8">  {{ $question['option_E'] }} </b></p>
                </th>
            </tr>
            <tr>
                <th style="width:20%"><p class="text-center"><button type="button" class="{{ in_array($question['id'].'-'.$question['option_A'], $selectedAnswers) ? 'btn btn-success border border-secondary rounded' : 'btn btn-light border border-secondary rounded' }}"
                    wire:click="answers({{ $question['id'] }}, '{{ $question['option_A'] }}'), nextPage"><a href="#" wire:click="nextPage"><font size="8">A</font></a></button></th>
                <th style="width:20%"><p class="text-center"><button type="button" class="{{ in_array($question['id'].'-'.$question['option_B'], $selectedAnswers) ? 'btn btn-success border border-secondary rounded' : 'btn btn-light border border-secondary rounded' }}"
                    wire:click="answers({{ $question['id'] }}, '{{ $question['option_B'] }}'), nextPage"><a href="#" wire:click="nextPage"><font size="8">B</font></a></button></th>
                <th style="width:20%"><p class="text-center"><button type="button" class="{{ in_array($question['id'].'-'.$question['option_C'], $selectedAnswers) ? 'btn btn-success border border-secondary rounded' : 'btn btn-light border border-secondary rounded' }}"
                    wire:click="answers({{ $question['id'] }}, '{{ $question['option_C'] }}'), nextPage"><a href="#" wire:click="nextPage"><font size="8">C</font></a></button></th>
                <th style="width:20%"><p class="text-center"><button type="button" class="{{ in_array($question['id'].'-'.$question['option_D'], $selectedAnswers) ? 'btn btn-success border border-secondary rounded' : 'btn btn-light border border-secondary rounded' }}"
                    wire:click="answers({{ $question['id'] }}, '{{ $question['option_D'] }}'), nextPage"><a href="#" wire:click="nextPage"><font size="8">D</font></a></button></th>
                <th style="width:20%"><p class="text-center"><button type="button" class="{{ in_array($question['id'].'-'.$question['option_E'], $selectedAnswers) ? 'btn btn-success border border-secondary rounded' : 'btn btn-light border border-secondary rounded' }}"
                    wire:click="answers({{ $question['id'] }}, '{{ $question['option_E'] }}'), nextPage"><a href="#" wire:click="nextPage"><font size="8">E</font></a></button></th>
            </tr>
        </table>
        </div>
        
    </div>
    @endforeach

    {{-- @foreach ($selectedAnswers as $item)
        {{ $item }}
    @endforeach --}}
    
    <!--<div class="d-flex justify-content-center">
        {{$questions->links()}}
    </div>-->
    <div class="card-footer">
        @if ($questions->currentPage() == $questions->lastPage())
            <button wire:click="submitAnswers" class="btn btn-primary btn-lg btn-block">Submit</button>
        @endif
    </div>
</div>

<script>
    var add_minutes =  function (dt, minutes) {
    return new Date(dt.getTime() + minutes*60000);
    }
    
    // Get today's date and time
    var now = new Date();

    // Set the date we're counting down to
    var countDownDate = add_minutes(now, {{ $exam->time }});

    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now2 = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now2;

    // Time calculations for days, hours, minutes and seconds
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    document.getElementById("timer").innerHTML = "Sisa Waktu : " + hours + " jam "
    + minutes + " menit "+ seconds + " detik ";

    // If the count down is finished, write some text
    if (distance < 0) {
      
            clearInterval(x);
            Livewire.emit('endTimer');
            
    }
    }, 1000);
</script>