import IconHeaderButton from "@/components/buttons/icon-header-button"
import FriendsScreen from "@/screens/friends"
import HomeScreen from "@/screens/home"
import ProfileScreen from "@/screens/profile"
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs"
import { HeaderButtons, Item } from "react-navigation-header-buttons"
import { AppIcon } from "./config/theme"

const RootTab = createBottomTabNavigator()

enum RootRoutes {
	HOME = "Home",
	FRIENDS = "Friends",
	PROFILE = "Profile",
}

export default function RootNavigator() {
	return (
		<RootTab.Navigator initialRouteName={RootRoutes.HOME} backBehavior="initialRoute">
			<RootTab.Screen
				name={RootRoutes.HOME}
				component={HomeScreen}
				options={{
					tabBarIcon: props => <AppIcon name="home-outline" {...props} />,
					headerShadowVisible: false,
				}}
			/>
			<RootTab.Screen
				name={RootRoutes.FRIENDS}
				component={FriendsScreen}
				options={{
					tabBarIcon: props => <AppIcon name="people" {...props} />,
					headerRight: () => (
						<HeaderButtons HeaderButtonComponent={IconHeaderButton}>
							<Item title="Search" iconName="search" onPress={() => {}} />
							<Item title="Requests" iconName="person-add" onPress={() => {}} />
						</HeaderButtons>
					),
				}}
			/>
			<RootTab.Screen
				name={RootRoutes.PROFILE}
				component={ProfileScreen}
				options={{
					tabBarIcon: props => <AppIcon name="person-circle" {...props} />,
				}}
			/>
		</RootTab.Navigator>
	)
}
