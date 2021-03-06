@extends('hr.layouts.app')
@section('title','Edit Candidate')
@section('content')

<div class="content">
<div class="container">

    <h2 class="my-5">Edit Candidates</h2>
    @if(session('error'))
        @component('alert')
            @slot('class')
                danger
            @endslot
            @slot('tag')
                Danger
            @endslot
            @slot('message')
                {{ session('error') }}
            @endslot
        @endcomponent
    @endif
    <div class="row mb-5">
        <div class="col-md-12">
        <form action="{{ route('interview.update',$interviewdetails->id) }}" method="post">
            @csrf
            @method('put')
            <div class="row mb-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_name">Name</label>
                        <input type="text" name="candidate_name" class="form-control" value="{{ $interviewdetails->name }}">
                        @if($errors->has('candidate_name'))
                            <p class="text-danger">{{ $errors->first('candidate_name') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_email">Email</label>
                        <input type="email" name="candidate_email" class="form-control" value="{{ $interviewdetails->email }}" placeholder="Enter Email">
                        @if($errors->has('candidate_email'))
                            <p class="text-danger">{{ $errors->first('candidate_email') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_graduate">Graduate</label>
                        <input type="text" name="candidate_graduate" class="form-control" value="{{ $interviewdetails->graduation }}" placeholder="Enter Graduate">
                        @if($errors->has('candidate_graduate'))
                            <p class="text-danger">{{ $errors->first('candidate_graduate') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_phone">Phonenumber</label>
                        <input type="number" name="candidate_phone" class="form-control" value="{{ $interviewdetails->phone }}" placeholder="Ente Phonenumber">
                        @if($errors->has('candidate_phone'))
                            <p class="text-danger">{{ $errors->first('candidate_phone') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_otherphone">Other Phonenumber</label>
                        <input type="number" name="candidate_otherphone" class="form-control" value="{{ $interviewdetails->other_phone }}" placeholder="Enter other Phonenumber">
                        @if($errors->has('candidate_otherphone'))
                            <p class="text-danger">{{ $errors->first('candidate_otherphone') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_category">Category</label>
                        <select name="candidate_category" id="candidate_category" class="form-control">
                            <option value="">Choose Category</option>
                            @forelse($categoryDetails as $category)
                                @if($interviewdetails->getCategory->name==$category->name)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @empty
                                <option>No Category Found</option>
                            @endforelse
                        </select>
                        @if($errors->has('candidate_category'))
                            <p class="text-danger">{{ $errors->first('candidate_category') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_expereince">Expereince</label>
                        <input type="number" name="candidate_expereince" class="form-control" value="{{ $interviewdetails->experience }}" placeholder="Enter Expereince" min="0">
                        @if($errors->has('candidate_expereince'))
                            <p class="text-danger">{{ $errors->first('candidate_expereince') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_current_salary">Current Salary</label>
                        <input type="number" name="candidate_current_salary" class="form-control" value="{{ $interviewdetails->current_salary }}" placeholder="Enter Current Salary" min="0">
                        @if($errors->has('candidate_current_salary'))
                            <p class="text-danger">{{ $errors->first('candidate_current_salary') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_expected_salary">  Expected Salary</label>
                        <input type="number" name="candidate_expected_salary" class="form-control" value="{{ $interviewdetails->expected_salary }}" placeholder="Enter Expected Salary" min="0">
                        @if($errors->has('candidate_expected_salary'))
                            <p class="text-danger">{{ $errors->first('candidate_expected_salary') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_practical_remarks">  Practical Remarks</label>
                        <input type="number" name="candidate_practical_remarks" class="form-control" value="{{ $interviewdetails->practical_remarks }}" placeholder="Enter Practical Remarks" min="0">
                        @if($errors->has('candidate_practical_remarks'))
                            <p class="text-danger">{{ $errors->first('candidate_practical_remarks') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_technical_remarks">  Technical Remarks</label>
                        <input type="number" name="candidate_technical_remarks" class="form-control" value="{{ $interviewdetails->technical_remarks }}" placeholder="Enter Technical Remarks" min="0">
                        @if($errors->has('candidate_technical_remarks'))
                            <p class="text-danger">{{ $errors->first('candidate_technical_remarks') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_general_remarks">  General Remarks</label>
                        <input type="number" name="candidate_general_remarks" class="form-control" value="{{ $interviewdetails->general_remarks }}" placeholder="Enter General Remarks" min="0">
                        @if($errors->has('candidate_general_remarks'))
                            <p class="text-danger">{{ $errors->first('candidate_general_remarks') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Update">
        </form>
        <div>
    </div>
</div>
    </div>
@endsection
