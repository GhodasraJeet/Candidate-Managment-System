@extends('hr.layouts.app')
@section('title','Display Single Interview')
@section('content')

<div class="content">
<div class="container">
    @if (session('error'))
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
    <h2 class="text-center my-5">Display Candidates</h2>
    <div class="row">
        <div class="container">
            <div class="main">
                <a href="/send" class="btn btn-default float-right">Send Email</a>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_name">Name</label>
                        <input type="text" name="candidate_name" class="form-control" value="{{ $interviewDetails['name'] }}" disabled>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_email">Email</label>
                        <input type="email" name="candidate_email" class="form-control" value="{{ $interviewDetails->email }}" placeholder="Enter Email" disabled>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_graduate">Graduate</label>
                        <input type="text" name="candidate_graduate" class="form-control" value="{{ $interviewDetails->graduation }}" placeholder="Enter Graduate" disabled>

                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_phone">Phonenumber</label>
                        <input type="number" name="candidate_phone" class="form-control" value="{{ $interviewDetails->phone }}" placeholder="Ente Phonenumber" disabled>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_otherphone">Other Phonenumber</label>
                        <input type="number" name="candidate_otherphone" class="form-control" value="{{ $interviewDetails->other_phone }}" placeholder="Enter other Phonenumber" disabled>

                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_category">Category</label>
                        <select name="candidate_category" id="candidate_category" class="form-control" multiple  disabled>
                            @if(count($interviewDetails->getCategory))
                                <option>{{$interviewDetails->getCategory->name}}</option>
                            @else
                                <option>No Found</option>
                            @endif
                        </select>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_expereince">Expereince</label>
                        <input type="number" name="candidate_expereince" class="form-control" value="{{ $interviewDetails->experience }}" placeholder="Enter Expereince" min="0" disabled>

                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_current_salary">Current Salary</label>
                        <input type="number" name="candidate_current_salary" class="form-control" value="{{ $interviewDetails->current_salary }}" placeholder="Enter Current Salary" min="0" disabled>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="candidate_expected_salary">  Expected Salary</label>
                        <input type="number" name="candidate_expected_salary" class="form-control" value="{{ $interviewDetails->expected_salary }}" placeholder="Enter Expected Salary" min="0" disabled>

                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_practical_remarks">  Practical Remarks</label>
                        <input type="number" name="candidate_practical_remarks" class="form-control" value="{{ $interviewDetails->practical_remarks }}" placeholder="Enter Practical Remarks" min="0" disabled>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_technical_remarks">  Technical Remarks</label>
                        <input type="number" name="candidate_technical_remarks" class="form-control" value="{{ $interviewDetails->technical_remarks }}" placeholder="Enter Technical Remarks" min="0" disabled>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="candidate_general_remarks">  General Remarks</label>
                        <input type="number" name="candidate_general_remarks" class="form-control" value="{{ $interviewDetails->general_remarks }}" placeholder="Enter General Remarks" min="0" disabled>

                    </div>
                </div>
            </div>
        <div>
    </div>
</div>
</div>
@endsection
