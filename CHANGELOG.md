# HOMM Social Feed Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres
to [Semantic Versioning](http://semver.org/).

## 2.1.3 - 2023-09-21

- set correct color #5

## 2.1.2 - 2022-09-21

- Fixed Emoji encoding in post message

## 2.1.1 - 2022-09-14

- Fixed field "posterName" in new installations
- Updated Version & Changelog

## 2.1.0 - 2022-09-12

- Added new field "posterName"

## 2.0.1 - 2022-07-22

- Fixed TypeError in elements/SocialFeed

## 2.0.0 - 2022-07-22

- Craft CMS 4 ready

## 1.2.6 - 2022-09-21

- Fixed Emoji encoding in post message

## 1.2.5 - 2022-09-14

- Fixed field "posterName" in new installations

## 1.2.4 - 2022-09-12

- Added new field "posterName"

## 1.2.3 - 2021-09-16

- Consistent plugin naming in all files
- Make the `$orderBy` parameter optional
- Updated PHPDocs and README.md
- Check if post image can be downloaded
- Get SocialFeeds with any status

## 1.2.2 - 2021-07-26

- Set images/videos to NULL (and not an empty string)

## 1.2.1 - 2021-06-21

- Fixed $schemaVersion

## 1.2.0 - 2021-06-21

- Added new field "additionalPhotos"

## 1.1.1 - 2021-06-11

- Changed update feeds button
- Use the cpUrl() function in settings.twig

## 1.1.0 - 2021-05-26

- Do not sort feeds globally to allow custom sorting
- Moved sorting to the SocialFeedVariable
- Fixed social feed api updates
- Updated dependencies
- Code refactoring
- Styling improvements
- Other small bugfixes

## 1.0.5 - 2021-04-21

- Remove emojis from post message
- Convert post attribute external_created_at before saving
- Format CHANGELOG.md

## 1.0.4 - 2021-04-14

- Fixed return value typehint

## 1.0.3 - 2021-04-14

- Some code refactoring
- Added "limit" parameter to SocialFeedVariable::all()
- Added plugin variable SocialFeedVariable::posts() to get the ElementQuery

## 1.0.2 - 2021-01-27

- Version update

## 1.0.1 - 2021-01-27

- Update README.md
- Update texts/translations
- Update settings feed example

## 1.0.0 - 2021-01-25

- Initial release
