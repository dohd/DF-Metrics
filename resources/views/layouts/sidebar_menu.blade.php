<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <!-- End Dashboard Nav -->

    {{-- User type: deacon, overseer --}}
    @if (in_array(auth()->user()->user_type, ['deacon', 'overseer']))
      <li class="nav-heading">Study Session</li>
      <!-- Study Materials -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('study_materials.index') }}">
          <i class="bi bi-archive-fill"></i></i><span>Study Materials</span>
        </a>
      </li>

      <!-- Testimonials -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('testimonials.index') }}">
          <i class="bi bi-card-list"></i></i><span>Study Testimonials</span>
        </a>
      </li> 

      <!-- Narrative Report -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('narratives.index') }}">
          <i class="bi bi-card-list"></i></i><span>Narrative Reports</span>
        </a>
      </li> 

      <li class="nav-heading">Metrics & Scores</li>
      <!-- metric input -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('metrics.index') }}">
          <i class="bi bi-list-check"></i><span>Metrics</span>
        </a>
      </li>
      <!-- assign scores -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('assign_scores.create') }}">
          <i class="bi bi-calculator"></i><span>Scores</span>
        </a>
      </li>
      <!-- key programmes -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('programmes.index') }}">
          <i class="bi bi-tag"></i><span>Programs</span>
        </a>
      </li>
      <!-- score cards -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('score_cards.index') }}">
          <i class="bi bi-kanban"></i><span>Rating Scale</span>
        </a>
      </li>
      <!-- teams -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('teams.index') }}">
          <i class="bi bi-people"></i><span>Teams</span>
        </a>
      </li>

      <!-- Reports -->
      <li class="nav-heading">Report Center</li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('reports.metric_summary') }}">
          <i class="bi bi-circle"></i><span>Program Metrics Summary</span>
        </a>
        <a class="nav-link collapsed" href="{{ route('reports.team_size_summary') }}">
          <i class="bi bi-circle"></i><span>Team Size Summary</span>
        </a>
        <a class="nav-link collapsed" href="{{ route('reports.monthly_pledge') }}">
          <i class="bi bi-circle"></i><span>Monthly Pledge Vs Actual</span>
        </a>
        <a class="nav-link collapsed" href="{{ route('reports.monthly_pledge_vs_mission') }}">
          <i class="bi bi-circle"></i><span>Monthly Pledge & Mission</span>
        </a>
        <a class="nav-link collapsed" href="{{ route('reports.score_variance') }}">
          <i class="bi bi-circle"></i><span>Score Variance</span>
        </a>
        <a class="nav-link collapsed" href="{{ route('reports.team_summary_performance') }}">
          <i class="bi bi-circle"></i><span>Performance Summary</span>
        </a>
        <a class="nav-link collapsed" href="{{ route('reports.team_report_card') }}">
          <i class="bi bi-circle"></i><span>Team Report Card</span>
        </a>
      </li>
      
      <li class="nav-heading">Settings</li>
      <!-- Age group -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('age_groups.index') }}"><i class="bi bi-kanban"></i><span>Age Groups</span></a>
      </li>
      <!-- Family Zones -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dfzones.index') }}"><i class="bi bi-list-check"></i><span>Family Zones</span></a>
      </li>
      <!-- DF Names -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dfnames.index') }}">
          <i class="bi bi-card-heading"></i><span>DF Names</span>
        </a>
      </li>
      <!-- Ministries -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('ministries.index') }}">
          <i class="bi bi-list-check"></i><span>Ministries</span>
        </a>
      </li>
      <!-- Departments -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('departments.index') }}">
          <i class="bi bi-back"></i><span>Departments</span>
        </a>
      </li>
      <!-- Member List -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('memberlists.index') }}">
          <i class="bi bi-person-lines-fill"></i></i><span>DF Member List</span>
        </a>
      </li>  
      <!-- user management -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('user_profiles.index') }}">
          <i class="bi bi-person-lines-fill"></i><span>Users</span>
        </a>
      </li>
      <!-- settings -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('config.general_settings') }}">
          <i class="bi bi-gear-fill"></i><span>General</span>
        </a>
      </li>
    @endif

    



    {{-- User type: shephered --}}
    @if (in_array(auth()->user()->user_type, ['shepherd']))
      <li class="nav-heading">Study Session</li>
      <!-- Study Materials -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('narratives.index') }}">
          <i class="bi bi-archive-fill"></i></i><span>Study Materials</span>
        </a>
      </li>
      <!-- Testimonials -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('case_studies.index') }}">
          <i class="bi bi-card-list"></i></i><span>Study Testimonials</span>
        </a>
      </li> 
      <li class="nav-heading">Metrics & Scores</li>
      <!-- metric input -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('metrics.index') }}">
          <i class="bi bi-list-check"></i><span>Metrics</span>
        </a>
      </li>
      @if (in_array(auth()->user()->user_type, ['shepherd']))
        <!-- teams -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{ route('teams.index') }}">
            <i class="bi bi-people"></i><span>Teams</span>
          </a>
        </li>
      @endif

      <!-- Reports -->
      <li class="nav-heading">Report Center</li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('reports.metric_summary') }}">
          <i class="bi bi-circle"></i><span>Metric Summary</span>
        </a>
        <a class="nav-link collapsed" href="{{ route('reports.team_size_summary') }}">
          <i class="bi bi-circle"></i><span>Team Size Summary</span>
        </a>
        <!-- Team Captain Performance Summary Access -->
        @php
          $currMonth = (int) date('m', strtotime(date('Y-m-d')));
          $accessMonth = (int) date('m', strtotime(auth()->user()->company->pfmance_report_start));
        @endphp
        @if (in_array(auth()->user()->user_type, ['deacon', 'overseer']) && $accessMonth <= $currMonth)
          <a class="nav-link collapsed" href="{{ route('reports.team_summary_performance') }}">
            <i class="bi bi-circle"></i><span>Performance Summary</span>
          </a>
        @endif
        <a class="nav-link collapsed" href="{{ route('reports.team_report_card') }}">
          <i class="bi bi-circle"></i><span>Team Report Card</span>
        </a>
      </li>
    @endif
  </ul>
</aside>
