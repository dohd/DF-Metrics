<div class="pagetitle">
  <div class="row">
    <div class="col-6">
      <h1>Family Member List</h1>
    </div>
    <div class="col-6">
        <a href="{{ route('memberlists.create') }}" class="btn btn-primary float-end ms-1"><i class="bi bi-plus-circle"></i> Create</a>
        <a href="{{ route('memberlists.index') }}" class="btn btn-secondary float-end"><i class="bi bi-card-list"></i> List</a>
    </div>
  </div>
  
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
      <li class="breadcrumb-item active"><a href="{{ route('memberlists.index') }}">Family Member List</a></li>
    </ol>
  </nav>
</div>
