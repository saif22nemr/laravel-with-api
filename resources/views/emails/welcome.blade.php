Welcome : {{$user->name}}
Thank you for use this site, Please you should verifed you email from this link: 
{{route('verifiy',$user->verification_token)}}