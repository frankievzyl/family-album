select * from `media` order by `Created`
select `name` from `tag` where `name` like "?*" order by `name`
exists any tags
select `media`.`mediaPK`, `media`.`filename`, `media_album`.`position` from `media` join `media_album` on `media`.`mediaPK` = `media_album`.`mediaPK` where `media_album`.`albumPK` = ? order by `created`, `position`
select top `albumPK`, `mediaPK` from `media_album` order by `bookmark`