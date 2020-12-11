@extends('admin.layouts.app')
@section('title','Candidate List')
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
        <h2 class="text-center py-4">Single Candidate</h2>
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="candidate_name">Name</label>
                                <input type="text" name="candidate_name" id="candidate_name" class="form-control" value="{{ $hrfulldetails->name }}" placeholder="Ente Name" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="candidate_email">Email</label>
                                <input type="email" name="candidate_email" id="candidate_email" class="form-control" value="{{ $hrfulldetails->email }}" placeholder="Enter Email" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="candidate_graduate">Graduate</label>
                                <input type="text" name="candidate_graduate" id="candidate_graduate" class="form-control" value="{{ $hrfulldetails->graduation }}" placeholder="Enter Graduate"disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">HR Details</label>
                                <input type="text" class="form-control" value="{{ $hrfulldetails->getHrdetails->name }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="candidate_phone">Phonenumber</label>
                                <input type="number" name="candidate_phone" class="form-control" value="{{ $hrfulldetails->phone }}" id="candidate_phone" placeholder="Ente Phonenumber"disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="candidate_otherphone">Other Phonenumber</label>
                                <input type="number" id="candidate_otherphone" name="candidate_otherphone" class="form-control" value="{{ $hrfulldetails->other_phone }}" placeholder="Enter other Phonenumber"disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="candidate_category">Category</label>
                                <select name="candidate_category" id="candidate_category" class="form-control" disabled>
                                    <option>{{$hrfulldetails->getcategory->name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="candidate_expereince">Expereince</label>
                                <input type="number" name="candidate_expereince" class="form-control" value="{{ $hrfulldetails->experience }}" id="candidate_expereince" placeholder="Enter Expereince" min="0" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="candidate_current_salary">Current Salary</label>
                                <input type="number" name="candidate_current_salary" class="form-control" value="{{ $hrfulldetails->current_salary }}" id="candidate_current_salary" placeholder="Enter Current Salary" min="0"disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="candidate_expected_salary">  Expected Salary</label>
                                <input type="number" name="candidate_expected_salary" class="form-control" value="{{ $hrfulldetails->expected_salary }}" id="candidate_expected_salary" placeholder="Enter Expected Salary" min="0" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="candidate_practical_remarks">Practical Remarks</label>
                                <input type="number" name="candidate_practical_remarks" id="candidate_practical_remarks" class="form-control" value="{{ $hrfulldetails->practical_remarks }}" placeholder="Enter Practical Remarks" min="0" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="candidate_technical_remarks">Technical Remarks</label>
                                <input type="number" name="candidate_technical_remarks" id="candidate_technical_remarks" class="form-control" value="{{ $hrfulldetails->technical_remarks }}" placeholder="Enter Technical Remarks" min="0" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="candidate_general_remarks">General Remarks</label>
                                <input type="number" name="candidate_general_remarks" id="candidate_general_remarks" class="form-control" value="{{ $hrfulldetails->general_remarks }}" placeholder="Enter General Remarks" min="0"disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
