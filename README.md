# siteapi

Wordpress SiteAPI Plugin

# 필요성

타이틀 제목, 이미지 변경 및 각 사이트 별 (테마 별) 외부로 내보내는 데이터를 관리해야하는 데

이러한 코드를 테마에 적용하면 모든 테마를 다 수정 해야 한다.

plugin 하나로 관리를 한다.

이 플러그인은 abc-library 를 의존한다.



# version change log

## option name from '_option' to 'siteapi'

Option name for storing form values has been changed from '_option' to 'siteapi'

The conversion code is stated on siteapi.php and is done automatically when you access "curl http://t.philgo.com/siteapi/info".

