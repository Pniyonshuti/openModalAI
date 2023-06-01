<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .typing-animation {
            animation: typing 3s steps(40) 1s forwards;
        }

        @keyframes typing {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }
    </style>


</head>

<body>
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-3">
            <nav class="flex items-center justify-between">
                <div>
                    <a href="#" class="text-gray-800 font-bold text-lg">Zatec - OpenAi Challenge</a>
                </div>
                <div>
                    <a href="/" class="text-gray-600 hover:text-gray-800">Home</a>
                    <a href="/" class="text-gray-600 hover:text-gray-800 ml-4">Questions</a>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8">
        <section class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Coding Challenge</h1>
            <h2 class="text-lg font-bold mb-2">Problem Statement</h2>
            <p class="text-gray-700 mb-6">
                <q>
                    write a Python program to find those numbers which are divisible by 7 and multiples of 5, between 1500 and 2700 (both included)

                    for i in range(1500,2701):
                    if i%7==0 and i%5==0:
                        print(" ",i)
                </q>
            </p>
            <div class="border-t border-gray-300 pt-6">
                <h2 class="text-lg font-bold mb-2">Your Solution</h2>
                <form method="post" action="/process">
                    @csrf
                    <div class="bg-gray-100 p-4 rounded-lg mb-6">
                        <textarea id="user-input" name="user_input"
                            class="w-full h-32 p-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Write your solution here..."></textarea>
                    </div>
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Submit</button>
                </form>
                <h2 class="text-lg font-bold mb-2 mt-6">Answer Verification</h2>
                <div class="bg-gray-100 p-4 rounded-lg mb-6">
                    <code class="text-gray-800">
                        <div >
                            @if(isset($generatedText))
                                {{-- {{ $generatedText }} --}}
                                <br>
                                @php
                                    $text = $generatedText;
                                    $goodPointsStartMarker = 'Good points:';
                                    $goodPointsEndMarker = 'Needed improvements:';
                                    $improvementsStartMarker = 'Needed improvements:';
                                    $overallMarker = 'Overall';

                                    $goodPointsStartPosition = strpos($text, $goodPointsStartMarker) + strlen($goodPointsStartMarker);
                                    $goodPointsEndPosition = strpos($text, $goodPointsEndMarker);
                                    $improvementsStartPosition = strpos($text, $improvementsStartMarker) + strlen($improvementsStartMarker);
                                    $overallStartPosition = strpos($text, $overallMarker);

                                    $goodPointsText = substr($text, $goodPointsStartPosition, $goodPointsEndPosition - $goodPointsStartPosition);
                                    $improvementsText = substr($text, $improvementsStartPosition, $overallStartPosition - $improvementsStartPosition);
                                    $overallText = substr($text, $overallStartPosition + strlen($overallMarker));

                                    $goodPointsList = explode('- ', $goodPointsText);
                                    $improvementsList = explode('- ', $improvementsText);
                                @endphp

                                <strong>Good Points:</strong>
                                <ul>
                                    @foreach ($goodPointsList as $index => $point)
                                        @if (!empty($point))
                                            <li><span class="mr-2 text-green-500">&#10003;</span>{{ trim($point) }}</li>
                                        @endif
                                    @endforeach
                                </ul>

                                <strong>Needed Improvements:</strong>
                                <ul>
                                    @foreach ($improvementsList as $index => $point)
                                        @if (!empty($point))
                                            <li><span class="mr-2 text-yellow-500">&#9888;</span>{{ trim($point) }}</li>
                                        @endif
                                    @endforeach
                                </ul>

                                <strong>Overall:</strong>
                                <p>{{ trim($overallText) }}</p>
                            @endif
                        </div>
                    </code>
                </div>
            </div>
        </section>
    </main>
    <script>
        @if(isset($generatedText))
            const text = {!! json_encode($generatedText) !!};
                const typingEffect = document.getElementById("typing-effect");
                function typeText() {
                typingEffect.innerHTML = '';
                typingEffect.classList.add('typing-animation');
                let i = 0;
                const typingInterval = setInterval(() => {
                    typingEffect.innerHTML += text[i];
                    i++;
                    if (i === text.length) {
                    clearInterval(typingInterval);
                    }
                }, 80);
            }
            typeText();
        @endif


    </script>
</body>

</html>
