@extends('hr.layouts.app')
@section('title','Mail')
@section('content')

<div class="content">
    <div class="container">
        <form action="{{route('sendmail')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Enter Subject</label>
                <input type="text" name="subject" class="form-control" placeholder="Enter Subject">
            </div>
            <div class="form-group">
                <label for="">Enter Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <b>Which you send ?</b><br>
                <div class="custom-control custom-radio">
                    <input type="radio" id="candidates" value="candidates" name="role" class="custom-control-input">
                    <label class="custom-control-label" for="candidates">All Candidates</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input type="radio" id="candidatecollapse" value="singlecandidates" name="role" class="custom-control-input"
                    data-toggle="collapse" data-parent="#candidatecollapse"">
                    <label class="custom-control-label" for="candidatecollapse">Candidates</label>
                  </div>
            </div>
            <div class="form-group collapse" id="candidatecollapsepanel">
                <label>Choose Candidate</label>
                <select name="singlecandidates[]" id="" class="form-control" multiple>
                    @forelse ($candidates as $candidate)
                        <option value="{{$candidate->id}}">{{$candidate->name}}</option>
                    @empty
                        <option value="">No Found</option>
                    @endforelse
                </select>
            </div>
            <input type="submit" value="Send Email" class="btn btn-primary">
        </form>

    </div>
</div>

@endsection
@section('js')
<script>
$('#hrcollapse,#candidatecollapse,#hr,#candidates').on('click', function (e) {
    e.stopPropagation();
    if(this.id == 'hrcollapse'){
        $('#candidatecollapsepanel').collapse('hide');
        $('#hrcollpasepanel').collapse('show');
    }
    else if(this.id ==  'candidatecollapse'){
        $('#hrcollpasepanel').collapse('hide');
        $('#candidatecollapsepanel').collapse('show');
    }
    else if(this.id=='candidates'||this.id=='hr'){
        $('#hrcollpasepanel').collapse('hide');
        $('#candidatecollapsepanel').collapse('hide');
    }
  })
</script>
@endsection
