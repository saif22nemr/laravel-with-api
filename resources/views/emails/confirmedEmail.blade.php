Welcome : {{$user->name}}
You are change email, for that you should confirm this mail by this link:
{{route('verifiy',$user->verification_token)}}