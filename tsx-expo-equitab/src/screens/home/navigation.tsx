import { ScreenOptions as TopTabsScreenOptions } from "@/lib/top-tabs"
import { createMaterialTopTabNavigator } from "@react-navigation/material-top-tabs"
import FriendsTab from "./friends"
import GroupsTab from "./groups"

const HomeTab = createMaterialTopTabNavigator<HomeTabParamList>()
export type HomeTabParamList = Record<"Friends" | "Groups", undefined>
export function HomeTabNavigation() {
	return (
		<HomeTab.Navigator initialRouteName="Friends" screenOptions={TopTabsScreenOptions}>
			<HomeTab.Screen name="Friends" component={FriendsTab} />
			<HomeTab.Screen name="Groups" component={GroupsTab} />
		</HomeTab.Navigator>
	)
}
