import { AppIcon } from "@/config/theme"
import { HeaderButton, type HeaderButtonProps } from "react-navigation-header-buttons"

export default function IconHeaderButton(props: HeaderButtonProps) {
	return <HeaderButton IconComponent={AppIcon} iconSize={23} {...props} />
}
