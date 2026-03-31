<x-public-layout>
    @include('includes.pages-breadcrumb')

    <section class="poll-section">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 mb-5">
                    <div class="poll-wrapper">

                        @php $i = 1; @endphp
                        @foreach($polls as $poll)
                            @php
                                $all_votes =
                                    ($poll->option1_votes ?? 0) +
                                    ($poll->option2_votes ?? 0) +
                                    ($poll->option3_votes ?? 0) +
                                    ($poll->option4_votes ?? 0) +
                                    ($poll->option5_votes ?? 0) +
                                    ($poll->option6_votes ?? 0);
                            @endphp

                            <form id="vote-form-{{ $poll->id }}" class="vote-form" data-poll-id="{{ $poll->id }}">
                                @csrf

                                <div class="poll-card">
                                    <div class="poll-header">
                                        <h3 class="poll-title">{{ _t($poll->title) }}</h3>
                                        <div class="poll-badge" title="Total Votes">
                                            <i class="fa fa-users"></i> {{ $all_votes }}
                                        </div>
                                    </div>

                                    <div class="voteForm-{{ $poll->id }} poll-options-area">
                                        <input type="hidden" name="poll_id" value="{{ $poll->id }}">

                                        @for($opt = 1; $opt <= 6; $opt++)
                                            @php
                                                $optKey = 'option'.$opt;
                                                $optVal = _t($poll->$optKey);
                                            @endphp

                                            @if($optVal)
                                                @php
                                                    // Unique ID generation preserved from your code
                                                    $uniqueId = $i . '-' . \Illuminate\Support\Str::limit($optVal, 10, '') . '-' . $opt;
                                                @endphp

                                                <div class="poll-option-wrapper">
                                                    <input type="radio"
                                                           id="{{ $uniqueId }}"
                                                           name="option"
                                                           value="{{ $optKey }}"
                                                           class="poll-radio-input">

                                                    <label for="{{ $uniqueId }}" class="poll-option-label">
                                                        <span class="check-circle"></span>
                                                        <span class="option-text">{{ $optVal }}</span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endfor

                                        <div class="poll-footer">
                                            <button type="submit" class="site-btn gold vote-submit-{{ $poll->id }}">
                                                {{ _t($p['opros']->title ?? '') }}
                                            </button>
                                        </div>
                                    </div>

                                    @php
                                        $totalVotes = $all_votes;
                                        $unit = $totalVotes > 0 ? 100 / $totalVotes : 0;

                                        // Colors for bars (Cycling)
                                        $colors = ['#D3A102', '#273140', '#003366', '#020105', '#6c757d', '#D3A102'];
                                    @endphp

                                    <div class="quiz-result-{{ $poll->id }} poll-results-area" style="display: none;">
                                        <h4 class="results-heading">{{ _t($p['results']->title ?? '') ?? 'Results' }}:</h4>

                                        @for($opt = 1; $opt <= 6; $opt++)
                                            @php
                                                $optKey = 'option'.$opt;
                                                $voteKey = 'option'.$opt.'_votes';
                                                $optVal = _t($poll->$optKey);
                                                $votes = $poll->$voteKey ?? 0;
                                                $percent = round($unit * $votes, 1);
                                                $barColor = $colors[($opt - 1) % count($colors)];
                                            @endphp

                                            @if($optVal)
                                                <div class="result-item">
                                                    <div class="result-info">
                                                        <span class="result-label">{{ $optVal }}</span>
                                                        <span class="result-val">{{ $percent }}%</span>
                                                    </div>
                                                    <div class="progress custom-progress">
                                                        <div class="progress-bar"
                                                             role="progressbar"
                                                             style="width: {{ $percent }}%; background-color: {{ $barColor }};"
                                                             aria-valuenow="{{ $percent }}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endfor

                                        <div class="thank-you-message">
                                            <i class="fa fa-check-circle"></i> {{ _t($p['thank_you_vote']->title ?? '') ?? 'Thank you for voting!' }}
                                        </div>
                                    </div>

                                </div>
                            </form>
                            @php $i++; @endphp
                        @endforeach

                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="sidebar-sticky-wrapper">
                        @include('includes.sidebar')
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        :root {
            --poll-gold: #D3A102;
            --poll-dark: #020105;
            --poll-bg: #F5F5F7;
            --poll-white: #ffffff;
            --poll-border: #e5e7eb;
            --poll-text: #1f2937;
        }

        .poll-section {
            padding: 40px 0 80px 0;
            background-color: #fff;
        }

        /* --- POLL CARD --- */
        .poll-card {
            background: var(--poll-bg);
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .poll-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-color: var(--poll-border);
        }

        /* Header */
        .poll-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
            gap: 15px;
        }

        .poll-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--poll-dark);
            margin: 0;
            line-height: 1.4;
        }

        .poll-badge {
            background: var(--poll-gold);
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* --- OPTIONS STYLING --- */
        .poll-options-area {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Hide Default Radio */
        .poll-radio-input {
            display: none;
        }

        /* Custom Label Card */
        .poll-option-label {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 16px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            width: 100%;
            margin: 0;
        }

        /* Check Circle Indicator */
        .check-circle {
            width: 20px;
            height: 20px;
            border: 2px solid #ccc;
            border-radius: 50%;
            margin-right: 15px;
            position: relative;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .check-circle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            background: #fff;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.2s ease;
        }

        .option-text {
            font-size: 1rem;
            color: var(--poll-text);
            font-weight: 500;
        }

        /* Hover State */
        .poll-option-label:hover {
            border-color: var(--poll-gold);
            background: #fffcf5; /* Light tint of gold */
        }

        /* Checked State */
        .poll-radio-input:checked + .poll-option-label {
            background: var(--poll-gold);
            border-color: var(--poll-gold);
            box-shadow: 0 4px 10px rgba(211, 161, 2, 0.3);
            transform: translateY(-2px);
        }

        .poll-radio-input:checked + .poll-option-label .option-text {
            color: #fff;
            font-weight: 600;
        }

        .poll-radio-input:checked + .poll-option-label .check-circle {
            border-color: #fff;
        }

        .poll-radio-input:checked + .poll-option-label .check-circle::after {
            transform: translate(-50%, -50%) scale(1);
        }

        /* Footer / Button */
        .poll-footer {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .site-btn.gold {
            background: var(--poll-gold);
            color: #fff;
            border: none;
            padding: 12px 28px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .site-btn.gold:hover {
            box-shadow: 0 5px 15px rgba(211, 161, 2, 0.4);
            transform: translateY(-2px);
        }

        /* --- RESULTS STYLING --- */
        .poll-results-area {
            animation: fadeIn 0.5s ease;
        }

        .results-heading {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--poll-dark);
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .result-item {
            margin-bottom: 15px;
        }

        .result-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #444;
        }

        .result-val {
            font-weight: 700;
            color: var(--poll-dark);
        }

        .custom-progress {
            height: 12px;
            background-color: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
        }

        .thank-you-message {
            margin-top: 25px;
            text-align: center;
            color: #27ae60; /* Success green */
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Sticky Sidebar */
        .sidebar-sticky-wrapper {
            position: sticky;
            top: 20px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .poll-card { padding: 20px; }
            .poll-option-label { padding: 14px; }
        }
    </style>

    <script>
        $(document).ready(function () {
            $('.vote-form').on('submit', function (e) {
                e.preventDefault();

                const form   = $(this);
                const pollId = form.data('poll-id');
                const option = form.find('input[name=option]:checked').val();

                if (!option) {
                    alert('{{ _t($p['select_option']->title ?? '') ?? 'Please select an option' }}');
                    return;
                }

                $.ajax({
                    url: '{{ route('polls.vote') }}',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        poll_id: pollId,
                        option: option
                    },
                    success: function (response) {
                        if (response.success) {
                            $('.quiz-result-' + pollId).slideDown(); // Smooth animation
                            $('.voteForm-' + pollId).slideUp();      // Smooth animation
                        } else {
                            alert('Vote failed.');
                        }
                    },
                    error: function () {
                        alert('Vote failed.');
                    }
                });
            });
        });
    </script>
</x-public-layout>
